<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyTeamRole;
use App\Models\Permission;
use App\Models\SuperadminTeamRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    //Users
    public function users_list(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = 'users';

        $users = User::select('users.*', 'co.company_name', 'ctr.title')
            ->leftJoin('companies as co', 'users.company_id', 'co.id')
            ->leftJoin('company_team_roles as ctr', 'users.role_id', 'ctr.id')
            ->where('users.active', '!=', 2);

        $routeName = Route::currentRouteName();
        $pageData['routeName'] = $routeName;
        $users = $users->where('users.company_id', 0)
            ->where('users.is_super_admin', 1)->get();

        $pageData['users'] = $users;

        return view('users.users', $pageData);
    }

    public function add_edit_user(Request $request, $user_id = null)
    {
        // dd($request->all());
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['edit_user_details'] = false;
        $pageData['onmodal'] = false;

        $routeName = Route::currentRouteName();
        $pageData['company_id'] = $user->company_id;
        $pageData['routeName'] = $routeName;

        if (!empty($user_id)) {
            $user_details = User::where('id', $user_id)->first();
            $pageData['user_details'] = $user_details;
            $pageData['edit_user_details'] = true;
        }

        $roles = SuperadminTeamRole::where('active', '!=', 2)->get();

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
                $pageData['onmodal'] = true;
                $modal_content = view('users.add_edit_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('users.users', $pageData);
    }

    public function post_add_edit_user(Request $request, $user_id = null)
    {
        $email = $request->email;
        $company_id = $request->company_id;
        $password = rand(11111, 99999);
        $routeName = Route::currentRouteName();

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


        $user_data['is_super_admin'] = 1;
        $company_name = "mTrack";

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

            return redirect('/superadmin/user/edit/' . $new_user_id)->with('success_msg', "Invitation send succesfully...");
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

    //Roles
    public function roles(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['user'] = $user;
        $pageData['flag'] = $flag;
        $routeName = Route::currentRouteName();

        $roles = SuperadminTeamRole::get();

        $pageData['company_id'] = $user->company_id;
        $pageData['routeName'] = $routeName;

        $get_all_permissions = Permission::where('active', '!=', 2)->get();

        $all_permissions = [];
        if (!empty($get_all_permissions)) {
            foreach ($get_all_permissions as $key => $val) {
                $all_permissions[$val->title][$val->id] = $val->type;
            }
        }

        $pageData['all_permissions'] = $all_permissions;

        if ($request->ajax()) {
            if ($request->has('role_id')) {
                $role = $roles->where('id', $request->role_id)->first();
                $role_has_permission = json_decode($role->permissions);
                $html = view('role&permission.edit_role_modal_form', compact('role', 'role_has_permission', 'all_permissions', 'routeName'))->render();

                return $html;
            }
        }

        foreach ($roles as $key => $val) {
            $permissions = [];
            $get_perm = json_decode($val->permissions);
            if (!empty($get_perm)) {
                foreach ($get_perm as $k => $v) {
                    $perm_details = Permission::where('id', $v)->where('active', '!=', 2)->first();
                    if (!empty($perm_details)) {
                        $permissions[$perm_details->title][$perm_details->id] = $perm_details->type;
                    }
                }
            }

            $roles[$key]->permissions = $permissions;
        }

        $pageData['roles'] = $roles;
        return view('role&permission.roles', $pageData);
    }

    public function post_roles(Request $request)
    {
        $user = auth()->user();
        $routeName = Route::currentRouteName();
        $validation_array = [
            'title' => 'required',
        ];

        if (isset($request->role_id)) {
            $validation_array['role_id'] = 'required';
        }

        if ($request->has('company_id')) {
            $validation_array['company_id'] = 'required';
        }

        $validator = Validator::make($request->all(), $validation_array, [
            'company_id' => "Please select company",
            'title' => "Role Name is required"
        ]);

        $withdata = [];
        if ($request->has('role_id')) {
            $withdata['role_id'] = $request->role_id;
            $withdata['modal_id'] = $request->modal_id;
        } else {
            $withdata['modal_id'] = $request->modal_id;
        }

        if ($validator->fails()) {
            return redirect()->back()->with($withdata)
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $request_data = $request->all();
        unset($request_data['company_id']);
        unset($request_data['_token']);
        unset($request_data['title']);
        unset($request_data['role_id']);
        unset($request_data['modal_id']);

        $permissions = [];
        if (!empty($request_data)) {
            foreach ($request_data as $key => $val) {
                $permissions[] = $val;
            }
        }

        $data = [
            'title' => $request->title,
            'permissions' => (!empty($permissions)) ? json_encode($permissions) : ''
        ];

        if ($request->has('role_id')) {
            SuperadminTeamRole::where('id', $request->role_id)->update($data);
            $msg = "Role Updated successfully...";
        } else {
            SuperadminTeamRole::insert($data);
            $msg = "Role added successfully...";
        }

        return redirect()->back()->with('success_msg', $msg);
    }

    public function permissions(Request $request, $permission_id = null)
    {
        $pageData['table_name'] = "permissions";
        $routeName = Route::currentRouteName();

        $permissions = Permission::where('active', '!=', 2)->get();
        $superadminroles = SuperadminTeamRole::get();
        $pageData['routeName'] = $routeName;

        foreach ($permissions as $key => $val) {
            $assign_to = [];

            if (isset($superadminroles)) {
                foreach ($superadminroles as $k => $v) {
                    $role_perm = json_decode($v->permissions);
                    if (!empty($role_perm)) {
                        if (in_array($val->id, $role_perm)) {
                            $assign_to[$v->id] = $v->title;
                        }
                    }
                }
            }

            $permissions[$key]->assign_to = $assign_to;
            if (!empty($permission_id) && $val->id == $permission_id) {
                $pageData['permission'] = $permissions[$key];
            }
        }

        if ($request->ajax()) {

            $edit_permission_form = view('role&permission.edit_permission_,modal_form', $pageData)->render();

            return $edit_permission_form;
        }

        $pageData['permissions'] = $permissions;
        return view('role&permission.permissions', $pageData);
    }

    public function post_permissions(Request $request)
    {
        $validation_array = [
            'title' => 'required',
            'type' => 'required'
        ];

        $routeName = Route::currentRouteName();
        $validator = Validator::make($request->all(), $validation_array, [
            'title' => "Permission Name is required"
        ]);

        $withdata['modal_id'] = $request->modal_id;

        if ($validator->fails()) {
            return redirect()->back()->with($withdata)
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'for_superadmin' => (isset($request->for_superadmin)) ?  1 : 0
        ];

        $alredy_exist = Permission::where('title', $data['title'])
            ->where('type', $data['type']);
        if ($request->has('permission_id')) {
            $alredy_exist = $alredy_exist->where('id', '!=', $request->permission_id);
        }
        $alredy_exist = $alredy_exist->count();

        if ($alredy_exist > 0) {
            $msg_type = "error_msg";
            $msg = "Permission already exist";
            return redirect()->back()->with($msg_type, $msg);
        }

        if ($request->has('permission_id')) {
            Permission::where('id', $request->permission_id)->update($data);
            $msg_type = "success_msg";
            $msg = "Permission updated successfully";
        } else {
            Permission::insert($data);
            $msg_type = "success_msg";
            $msg = "Permission added successfully";
        }

        return redirect('/superadmin/permissions')->with($msg_type, $msg);
    }
}
