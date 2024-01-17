<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyTeamRole;
use App\Models\SuperadminTeamRole;
use App\Models\User;
use App\Models\UserLoginSession;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function sign_in()
    {
        if (Auth::user()) {
            return redirect('/dashboard');
        }
        return view('users.authentication.sign_in');
    }

    public function sign_in_post(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = auth()->user();
            $flag = $user->is_super_admin;

            if ($user->active == 0 || $user->active == 2) {
                Auth::logout();
                $request->session()->put('error_msg', "Login not allowed!");
                return redirect('/sign_in');
            } elseif ($user->active == 3) {
                Auth::logout();
                $request->session()->put('error_msg', "Login not allowed! Your request not approved yet");
                return redirect('/sign_in');
            }

            $request->user()->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);

            $signin_at_id = UserLoginSession::insertGetId([
                'user_id' => $user->id,
                'type' => ($flag == 1) ? 3 : 2
            ]);

            $request->session()->put('signin_at_id', $signin_at_id);

            return redirect('/dashboard');
        } else {
            return redirect('/sign_in')->with('error_msg', 'Login Fail Check Credentials...');
        }
    }

    public function sign_out()
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;

        $signin_at_id = session()->get('signin_at_id');

        UserLoginSession::where('id', $signin_at_id)->update(['sign_out' => date('Y-m-d H:i:s')]);

        session()->flush();
        Auth::logout();
        return redirect('/sign_in');
    }

    public function sign_up()
    {
        return view('users.authentication.sign_up');
    }

    public function sign_up_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website' => 'required',
            'company' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'toc' => 'required'
        ], [
            'website' => "Company web site is requied",
            'company' => "Company Name Required",
            'toc' => "You must accept the terms and conditions"
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $email_domain = explode('@', $request->email);
        $email_domain = $email_domain[1];
        $not_allowed_email = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];

        if (in_array($email_domain, $not_allowed_email)) {
            return redirect()->back()->with('error_msg', 'This email domain not allowed enter your work email e.g. xyz@company_name.com');
        }

        $all_contact_emails = Company::where('active', '!=', 2)->get();
        $existing_company = true;
        $company_id = 0;

        foreach ($all_contact_emails as $val) {
            $company_email_domain = explode('@', $val->contact_email);
            if ($email_domain == $company_email_domain[1]) {
                $company_id = $val->id;
            }
        }

        if ($company_id == 0) {
            $existing_company = false;
            $company_info = [
                'company_name' => $request->company,
                'company_website' => $request->website,
                'contact_name' => $request->name,
                'contact_email' => $request->email,
                'active' => 0,
            ];

            $company_id = Company::insertGetId($company_info);
        }

        $user_info = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $company_id,
            'last_login_at' => \Illuminate\Support\Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp(),
            'active' => 0,
        ];

        $comp_users = User::where('company_id', $company_id)->where('is_company_super_admin', 1)->first();
        if ($existing_company == false || empty($comp_users)) {
            $user_info['is_company_super_admin'] = 1;
        } elseif (!empty($comp_users)) {
            $user_info['active'] = 3;
        }

        $already_exist = User::where('email', $request->email)
            ->where('company_id', $company_id)
            ->first();

        if (empty($already_exist)) {
            $user_id = User::insertGetId($user_info);
        } else {
            return redirect('/sign_in')->with('success_msg', "Already Registered email");
        }

        $sentRequest = requestOtp($request->name, $request->email);
        if ($sentRequest != false) {
            $request->session()->put('otp_sent', ['name' => $request->name, 'email' => $request->email, 'success_msg' => $sentRequest, 'user_id' => $user_id, 'comp_id' => $company_id]);
            $request->session()->put('attempt', 1);
            return redirect('/verify_otp')->with('success_msg', 'OTP sent on your email!');
        } else {
            return redirect()->back()->with('error_msg', "Something went wrong!");
        }
    }

    public function forgot_password()
    {
        return view('users.authentication.forgot_password');
    }

    public function forgot_password_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = md5(time());
        $query = User::where('email', $request->email)->first();
        $id = $query->id;
        User::where('email', $request->email)->update(['remember_token' => $token]);
        $email = $request->email;
        $template = url('/') . "/verify/$id/$token";
        $array = ['template' => $template];

        $subject = 'Reset your password';
        // Mail::send('users.authentication.sendpassword', $array, function ($message) use ($email, $template, $subject) {
        //     $message->to($email)
        //         ->subject($subject);
        //     // $message->setBody($template, 'text/html');
        // });

        return redirect('/sign_in')->with('success_msg', "We have sent a password reset link in your email");
    }

    public function verify(Request $request, $id, $token)
    {
        $array = [
            'id'  => $id,
            'token' => $token
        ];
        $validator = Validator::make($array, [
            'id' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        $query = User::where('id', $id)->first();
        $email = $query->email;
        $password = time();
        $array = ['setpassword' => $password];
        if ($token == $query->remember_token) {
            $subject = 'new password generated';
            // Mail::send('users.authentication.sendpassword', $array, function ($message) use ($email, $password, $subject) {
            //     $message->to($email)
            //         ->subject($subject);
            //     // $message->setBody($template, 'text/html');
            // });

            User::where('email', $query->email)->update(['password' => bcrypt($password)]);
            $query = User::where('id', $id)->first();
        }
        return redirect('/sign_in')->with('success_msg', "Password Reset Successfully! Get password from Gmail.");
    }

    public function verify_otp(Request $request)
    {
        if ($request->ajax()) {
            $sentRequest = requestOtp("", $request->email);
            if ($sentRequest != false) {
                return ['success_msg' => "OTP sent successfully"];
            } else {
                return ['error_msg' => "Something went wrong"];
            }
        }

        return view('users.authentication.verify_otp');
    }

    public function verify_otp_post(Request $request)
    {
        $request->validate([
            'verification_otp' => 'required'
        ]);

        $verify_otp = verifyOtp($request->email, $request->verification_otp);

        if ($verify_otp == "Invalid OTP") {
            $attempt = $request->session()->get('attempt');

            if ($attempt > 3) {
                $request->session()->forget('attempt');
                return redirect('/sign_up')->with('error_msg', 'Exceeds attempt limit please request again for OTP!');
            }

            $attempt++;

            $request->session()->put('attempt', $attempt);
            return redirect()->back()->with('error_msg', $verify_otp);
        } elseif ($verify_otp == "true") {

            $otp_details = $request->session()->get('otp_sent');

            if (!empty($otp_details)) {
                $register_user = User::where('id', $otp_details['user_id'])->first();
                $msg = "You registration request sent successfully, You can login after request approved by company adminstration";
                if ($register_user->active != 3) {

                    $msg = "You registration completed successfully, now You can login";

                    User::where('id', $otp_details['user_id'])->update(['active' => 1]);
                }

                Company::where('id', $otp_details['comp_id'])->update(['active' => 1]);
            }

            $request->session()->forget('otp_sent');
            $request->session()->forget('attempt');
            return redirect('/sign_in')->with('success_msg', $msg);
        } elseif ($verify_otp == false) {
            return redirect('/sign_up')->with('error_msg', 'Something went wrong try agin later!');
        }
    }

    public function users_list(Request $request, $comp_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['user'] = $user;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = 'users';
        $company_id = $user->company_id;

        $users = User::select('users.*', 'co.company_name', 'ctr.title')
            ->leftJoin('companies as co', 'users.company_id', 'co.id')
            ->leftJoin('company_team_roles as ctr', 'users.role_id', 'ctr.id')
            ->where('users.active', '!=', 2);

        if ($flag != 1 || !empty($comp_id)) {
            if (!empty($comp_id)) {
                $company_id = $comp_id;
                $pageData['prev_page_id'] = $comp_id;
            }

            $users = $users->where('users.company_id', $company_id);
        }

        $users = $users->get();

        $pageData['users'] = $users;

        return view('users.users', $pageData);
    }

    public function add_edit_user(Request $request, $user_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['edit_user_details'] = false;
        $pageData['onmodal'] = false;

        if ($flag == 1) {
            $companies = Company::where('active', 1)->get();
            $pageData['companies'] = $companies;
        } else {
            $pageData['company_id'] = $user->company_id;
        }

        if (!empty($user_id)) {
            $user_details = User::where('id', $user_id)->first();
            $pageData['user_details'] = $user_details;
            $pageData['edit_user_details'] = true;
        }

        $roles = CompanyTeamRole::where('active', '!=', 2);
        if ($flag != 1 || ($request->has('company_id') && !empty($request->company_id))) {
            if (!empty($request->company_id)) {
                $pageData['company_id'] = $request->company_id;
            }

            $roles = $roles->where('company_id', $pageData['company_id']);
        }

        $roles = $roles->get();

        $pageData['roles'] = $roles;

        if ($request->ajax()) {

            if ($request->has('company_id')) {
                $options = '<option value="">Select Role</option>';
                foreach ($roles as $key => $val) {
                    if ($user_details->role_id == $val->id) {
                        $options .= '<option selected value="' . $val->id . '">' . $val->title . '</option>';
                    } else {
                        $options .= '<option value="' . $val->id . '">' . $val->title . '</option>';
                    }
                }

                return $options;
            }

            if ($request->has('page') && $request->page == "view_user") {
                $pageData['onmodal'] = true;
                $modal_content = view('users.user_details_view', $pageData)->render();
                return $modal_content;
            } else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('users.add_edit_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('users.add_edit_user', $pageData);
    }

    public function post_add_edit_user(Request $request, $user_id = null)
    {
        $email = $request->email;
        $company_id = $request->company_id;
        $password = rand(11111, 99999);

        $validation_array = [
            'company_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function ($query) use ($email, $company_id, $user_id) {
                return $query->where('email', $email)
                    ->where('company_id', $company_id)
                    ->where('id', '!=', $user_id)
                    ->where('active', '!=', 2);
            })],
            'profile_pic' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048']
        ];

        $validator = Validator::make($request->all(), $validation_array, [
            'Company_id' => "Company is Required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $user_data = [
            'name' => $request->name,
            'email' => $email,
            'company_id' => $company_id,
            'role_id' => (isset($request->role_id)) ? $request->role_id : 0
        ];

        $path = "";
        if ($request->has('profile_pic') && !empty($request->profile_pic)) {
            $path = upload_picture($request->profile_pic);
            $user_data['profile_pic'] = $path;
        }

        if ($company_id != 0) {
            $company = Company::where('id', $company_id)->first();
            $company_name = $company->company_name;
        }

        if (empty($user_id)) {
            $user_data['password'] = bcrypt($password);
            $new_user_id = User::insertGetId($user_data);

            $user_data['invitation_msg'] = $request->invite_message;
            $user_data['password'] = $password;

            $subject = "Invitation from " . $company_name;
            // Mail::send('users.authentication.sendpassword', $user_data, function ($message) use ($email, $subject) {
            //     $message->to($email)
            //         ->subject($subject);
            // });

            return redirect()->back()->with('success_msg', "Invitation send succesfully...");
        } else {
            if ($request->has('reset_password')) {
                $user_data['password'] = bcrypt($password);
            }

            User::where('id', $user_id)->update($user_data);

            if ($request->has('reset_password')) {
                $user_data['setpassword'] = $password;
                $subject = "Reset Password";
                // Mail::send('users.authentication.sendpassword', $user_data, function ($message) use ($email, $subject) {
                //     $message->to($email)
                //         ->subject($subject);
                // });
                return redirect()->back()->with('success_msg', "Password reset succesfully...");
            }

            return redirect()->back()->with('success_msg', "User details updated succesfully...");
        }
    }
}
