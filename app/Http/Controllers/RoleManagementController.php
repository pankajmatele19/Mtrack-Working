<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyTeamRole;
use App\Models\Permission;
use App\Models\SuperadminTeamRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class RoleManagementController extends Controller
{
    public function roles(Request $request, $comp_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $company_id = $user->company_id;

        $roles = CompanyTeamRole::from('company_team_roles as ctr')
            ->select('ctr.*', 'co.company_name', 'co.id as comp_id')
            ->join('companies as co', 'ctr.company_id', 'co.id');

        if ($flag != 1 || !empty($comp_id)) {
            if (!empty($comp_id)) {
                $company_id = $comp_id;
                $pageData['prev_page_id'] = $company_id;
            }

            $roles =  $roles->where('company_id', $company_id);
        }

        $roles = $roles->get();

        if ($flag == 1) {
            $companies = Company::where('active', '!=', 2)->get();
            $pageData['companies'] = $companies;
        } else {
            $pageData['company_id'] = $company_id;
        }

        $get_all_permissions = Permission::where('active', '!=', 2);

        if ($flag != 1) {
            $get_all_permissions = $get_all_permissions->where('for_superadmin', 0);
        }

        $get_all_permissions = $get_all_permissions->get();

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
                $html = view('role&permission.edit_role_modal_form', compact('role', 'role_has_permission', 'all_permissions'))->render();

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

        $data['company_id'] = $request->company_id;

        if ($request->has('role_id')) {
            CompanyTeamRole::where('id', $request->role_id)->update($data);
            $msg = "Role Updated successfully...";
        } else {
            CompanyTeamRole::insert($data);
            $msg = "Role added successfully...";
        }

        return redirect()->back()->with('success_msg', $msg);
    }

    public function permissions(Request $request, $permission_id = null)
    {
        $pageData['table_name'] = "permissions";

        $permissions = Permission::where('active', '!=', 2)
            ->where('for_superadmin', '!=', 1)
            ->get();

        $roles = CompanyTeamRole::get();

        foreach ($permissions as $key => $val) {
            $assign_to = [];
            foreach ($roles as $k => $v) {
                $role_perm = json_decode($v->permissions);
                if (!empty($role_perm)) {
                    if (in_array($val->id, $role_perm)) {
                        $assign_to[$v->id] = $v->title;
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

        return redirect('/permissions')->with($msg_type, $msg);
    }
}
