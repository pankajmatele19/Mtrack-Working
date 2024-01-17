<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyTeamRole;
use App\Models\SuperadminTeamRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function view_profile()
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $company = Company::where('id', $user->company_id)->first();

        if ($flag == 1) {
            $roles = SuperadminTeamRole::get();
            $pageData['roles'] = $roles;
            if ($user->role_id) {
                $role = SuperadminTeamRole::where('id', $user->role_id)->first();
                $pageData['role'] = $role;
            }
        } else {
            $roles = CompanyTeamRole::where('company_id', $user->company_id)->get();
            $pageData['roles'] = $roles;
            if ($user->role_id) {
                $role = CompanyTeamRole::where('id', $user->role_id)->first();
                $pageData['role'] = $role;
            }
        }

        $pageData['user'] = $user;
        $pageData['company'] = $company;
        $pageData['countries'] = $this->getCountry();
        $pageData['languages'] = $this->getLanguages();
        $pageData['timezones'] = getTimezoneList();
        $pageData['datetimeformat'] = datetimeformat();

        foreach ($pageData['countries'] as $k => $v) {
            if (!empty($user->country) && $v->id == $user->country) {
                $pageData['country'] = $v->name;
            }
        }

        foreach ($pageData['languages'] as $k => $v) {
            if (!empty($user->language_id) && $v->id == $user->language_id) {
                $pageData['language'] = $v->value;
            }
        }

        return view('profile.myprofile', $pageData);
    }

    public function update_profile(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $email = $request->email;
        $company_id = $user->company_id;
        $password = rand(11111, 99999);

        $validation_array = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function ($query) use ($email, $company_id, $user_id) {
                return $query->where('email', $email)
                    ->where('company_id', $company_id)
                    ->where('id', '!=', $user_id)
                    ->where('active', '!=', 2);
            })],
            'profile_pic' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'phone' => ['numeric', 'min:5']
        ];

        $validator = Validator::make($request->all(), $validation_array,);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $email_domain = explode('@', $request->email);
        $email_domain = $email_domain[1];
        $not_allowed_email = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];

        if (in_array($email_domain, $not_allowed_email)) {
            return redirect()->back()->withErrors(['email' => "This email domain not allowed enter your work email e.g. xyz@company_name.com"])->withInput($request->input());
        }

        $user_data = [
            'name' => $request->name,
            'email' => $email,
            'company_id' => $company_id,
            'phone' => $request->phone,
            'country' => $request->country,
            'language_id' => $request->language_id,
        ];

        $path = "";
        if ($request->has('profile_pic') && !empty($request->profile_pic)) {
            // $old_path = $user->profile_pic;
            // if (!empty($old_path)) {
            //     unlink(public_path() . '/' . $old_path);
            // }
            $path = upload_picture($request->profile_pic);
            $user_data['profile_pic'] = $path;
        }

        if ($request->has('role_id')) {
            $user_data['role_id'] = $request->role_id;
        }

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
            return redirect()->back()->with('success_msg', "Please check your email. Password reset succesfully...");
        }

        return redirect()->back()->with('success_msg', "Profile details updated succesfully...");
    }

    public function update_company(Request $request)
    {
        $user = auth()->user();
        $validation_array = [
            'company_name' => ['required', 'string', 'max:255'],
            'about_company' => 'required',
            'country' => 'required',
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['numeric', 'digits_between:5,10'],
            'timezone' => 'required',
            'date_time_format' => 'required',
            'company_logo' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'company_address' => 'required'
        ];

        $validation_array['contact_email'] = ['required', 'string', 'email', 'max:255', Rule::unique('companies')->ignore($user->company_id)];

        $validator = Validator::make($request->all(), $validation_array, [
            'company_name' => "Company Name Required",
            'about_company' => "Please describe about company",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $email_domain = explode('@', $request->contact_email);
        $email_domain = $email_domain[1];
        $not_allowed_email = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];

        if (in_array($email_domain, $not_allowed_email)) {
            return redirect()->back()->withErrors(['contact_email' => "This email domain not allowed enter your work email e.g. xyz@company_name.com"])->withInput($request->input());
        }

        $company_info = [
            'company_name' => $request->company_name,
            'company_website' => $request->company_website,
            'about_company' => $request->about_company,
            'country' => $request->country,
            'company_address' => $request->company_address,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'timezone' => $request->timezone,
            'date_time_format' => $request->date_time_format,
            'active' => 1,
        ];

        $path = "";
        if ($request->has('company_logo') && !empty($request->company_logo)) {
            $path = upload_picture($request->company_logo);
        }

        $company = Company::where('id', $user->company_id)->first();
        if ($request->avatar_remove == 1) {
            $company_info['company_logo'] = null;
            $old_path = $company->company_logo;
            unlink(public_path() . '/' . $old_path);
        } elseif (!empty($path)) {
            $company_info['company_logo'] = $path;
        }

        if (!empty($company)) {
            Company::where('id', $user->company_id)->update($company_info);
            $msg = "Company Details Updated successfullY";

            return redirect()->back()->with('success_msg', $msg);
        } else {
            $msg = "Something Went Wrong!";
            return redirect()->back()->with('error_msg', $msg);
        }
    }
}
