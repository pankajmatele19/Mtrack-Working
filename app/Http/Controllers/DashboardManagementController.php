<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardManagementController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "get_secret") {
                $jwt_token = generate_jwt_token($request->emp_id);

                return ['jwt_token' => $jwt_token];
            }
        }

        $employees = Employee::from('employees as emp')
            ->select('emp.*')
            ->where('emp.active', 1)
            ->join('tracker_sessions as ts', 'emp.id', 'ts.employee_id')
            ->where('ts.is_active', 1);
        if ($flag != 1) {
            $employees = $employees->where('emp.company_id', $user->company_id);
        }
        $employees = $employees->get();
        $pageData['employees'] = $employees;
        return view('dashboards.dashboard', $pageData);
    }
}
