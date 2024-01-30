<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentNonProductiveApp;
use App\Models\EmployeeWiseProductiveApp;
use App\Models\Company;
use App\Models\Application;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;
use Psy\Readline\Hoa\Console;

use App\Models\CompanyApplicationsNonProductive; // Adjust the namespace according to your application's structure
use App\Models\CompanyApplicationsCategory; // Adjust the namespace according to your application's structure


class DepartmentManagementController extends Controller
{
    public $settings = [
        'track_applications' => [
            "title" => "Track Applications",
            "value" => 1,
            "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, cumque."
        ],
        'live_camera' => [
            "title" => "Live Camera",
            "value" => 0,
            "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, cumque."
        ],
        'live_screen' => [
            "title" => "Live Screen",
            "value" => 0,
            "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, cumque."
        ],
        'live_interval' => [
            "title" => "Live Interval",
            "value" => 2,
            "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, cumque.",
            "interval" => "in seconds"
        ],
        'track_activities' => [
            "title" => "Track Activites",
            "value" => 1,
            "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, cumque."
        ],
        'track_activities_interval' => [
            "title" => "Track Activites Interval",
            "value" => 10,
            "description" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet, cumque.",
            "interval" => "in seconds"
        ],
    ];
    public function departments(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = "departments";

        // Include the join with companies table
        $departmentsQuery = Department::select('departments.*', 'companies.company_name')
            ->join('companies', 'departments.company_id', '=', 'companies.id')
            ->where('departments.status', '!=', 2);

        if (!$flag) {
            // Normal user - filter by their own company
            $departmentsQuery->where('departments.company_id', '=', $user->company_id);
        }

        $departments = $departmentsQuery->get();

        $pageData['departments'] = $departments;

        return view('departments.departments', $pageData);
    }

    public function add_edit_department(Request $request, $dept_id)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData = [];
        $pageData['flag'] = $flag;
        $pageData['company_id'] = $user->company_id;
        // Check if the user is a super admin
        if ($user->is_super_admin) {
            $pageData['company_name'] = 'Select company'; // Set a default value for super admins
        } else {
            // Assuming you have a 'companies' table and a 'company_name' column
            $pageData['company_name'] = Company::find($user->company_id)->company_name;
        }
        $pageData['edit_dept_details'] = false;
        $pageData['onmodal'] = false;
        $companies = Company::where('active', 1)->get();
        $pageData['companies'] = $companies;

        // Assuming you have a 'departments' table
        $settings = $this->settings;
        // Fetch department details along with the company name

        $departmentsQuery = Department::select('departments.*', 'companies.company_name')
            ->join('companies', 'departments.company_id', '=', 'companies.id')
            ->where('departments.status', '!=', 2);

        if (!$flag) {
            // If not a super admin, filter by the user's company_id
            $departmentsQuery->where('departments.company_id', '=', $user->company_id);
        }

        $departments = $departmentsQuery->get();

        if (!empty($dept_id)) {
            $dept_details = $departments->where('id', $dept_id)->first();
            // Include the company_name by fetching it using the foreign key company_id
            $pageData['company_id'] = $dept_details->company_id;
            $pageData['company_name'] = $dept_details->company_name; // Add this line
            $pageData['dept_details'] = $dept_details;
            $pageData['edit_dept_details'] = true;

            // Assuming you have corresponding fields in the 'departments' table
            foreach ($settings as $key => $val) {
                if (isset($dept_details->$key)) {
                    $settings[$key]['value'] = $dept_details->$key;
                }
            }
        }

        $pageData['settings'] = $settings;

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_department") {
                $pageData['onmodal'] = true;
                $modal_content = view('departments.department_details_view', $pageData)->render();
                return $modal_content;
            } else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('departments.add_edit_department_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('departments.departments', $pageData);
    }

    public function post_add_edit_department(Request $request, $dept_id = null)
    {
        // dd($request->all());
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id', // Assuming 'companies' is your companies table
        ]);

        // Assuming you have a 'departments' table
        $department = new Department();

        // If editing, retrieve the existing department
        if (!empty($dept_id)) {
            $department = Department::find($dept_id);
        }

        // Assign form data to the department model
        $department->department_name = $request->input('name');
        $department->department_desc = $request->input('description');
        $department->company_id = $request->input('company_id');
        $department->status = 1; // Assuming 1 is active, you can adjust based on your status values


        // Save the department
        $department->save();

        // Redirect back or to a different page after successful form submission
        return redirect()->route('departments')->with('success', 'Department saved successfully!');
    }

    public function delete_department(Request $request, $dept_id)
    {
        // Find the department by ID
        $department = Department::find($dept_id);
        if (!$department) {
            // Handle the case where the department with the given ID is not found
            return redirect()->route('departments')->withErrors(['error' => 'Department not found']);
        }

        // Delete the department
        $department->delete();

        // Redirect back with a success message
        return redirect()->route('departments')->with('success', 'Department deleted successfully');
    }

    public function departments_app(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = "department_wise_productive_apps";

        // Include the join with departments, companies, company_applications_nonproductive, and company_applications_categories tables
        $departmentNonProductiveApps = DB::table('department_wise_productive_apps')
            ->select(
                'department_wise_productive_apps.*',
                'departments.department_name',
                'companies.company_name',
                'company_applications_nonproductive.app_name',
                // 'company_applications_nonproductive.status',
                'company_applications_categories.category_name'
            )
            ->join('departments', 'department_wise_productive_apps.department_id', '=', 'departments.id')
            ->join('companies', 'department_wise_productive_apps.company_id', '=', 'companies.id')
            ->join('company_applications_nonproductive', 'department_wise_productive_apps.app_id', '=', 'company_applications_nonproductive.id')
            ->join('company_applications_categories', 'company_applications_nonproductive.category_id', '=', 'company_applications_categories.id');

        if (!$flag) {
            // Normal user - filter by their own company
            $departmentNonProductiveApps->where('department_wise_productive_apps.company_id', '=', $user->company_id);
        }

        $departmentNonProductiveApps = $departmentNonProductiveApps->get();

        $pageData['departmentNonProductiveApps'] = $departmentNonProductiveApps;

        return view('departments.departments_app', $pageData);
    }

    public function add_edit_departments_app(Request $request, $app_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData = [];
        $pageData['flag'] = $flag;
        $pageData['edit_app_details'] = false;
        $pageData['onmodal'] = false;

        $pageData['categories'] = CompanyApplicationsCategory::all();
        $pageData['departments'] = Department::all();
        $pageData['applications'] = CompanyApplicationsNonProductive::all();
        $pageData['companies'] = Company::all();
        $appQuery = DB::table('department_wise_productive_apps')
            ->select(
                'department_wise_productive_apps.*',
                'departments.department_name',
                'companies.company_name',
                'company_applications_nonproductive.app_name',
                'company_applications_nonproductive.status',
                'company_applications_nonproductive.category_id'
            )
            ->join('departments', 'department_wise_productive_apps.department_id', '=', 'departments.id')
            ->join('companies', 'department_wise_productive_apps.company_id', '=', 'companies.id')
            ->join('company_applications_nonproductive', 'department_wise_productive_apps.app_id', '=', 'company_applications_nonproductive.id');
        $pageData['userCompanyId'] = $user->company_id;
        if (!$flag) {
            // Normal user - filter by their own company
            // Add additional data you need for the form, e.g., category list
            $pageData['categories'] = CompanyApplicationsCategory::where('company_id', $user->company_id)->get();
            $pageData['departments'] = Department::where('company_id', $user->company_id)->get();
            $pageData['applications'] = CompanyApplicationsNonProductive::where('company_id', $user->company_id)->get();
            $appQuery->where('department_wise_productive_apps.company_id', '=', $user->company_id);
        }

        if (!empty($app_id)) {
            $app_details = $appQuery
                ->where('department_wise_productive_apps.id', $app_id)
                ->first();

            $pageData['app_details'] = $app_details;
            $pageData['edit_app_details'] = true;
        }

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_app") {
                $pageData['onmodal'] = true;
                $modal_content = view('departments.app_details_view', $pageData)->render();
                return $modal_content;
            }
            // elseif ($request->has('company_id')) {
            //     // Handle AJAX request to fetch data based on the selected company
            //     $companyId = $request->company_id;

            //     $applications = CompanyApplicationsNonProductive::where('company_id', $companyId)->get();
            //     $categories = CompanyApplicationsCategory::where('company_id', $companyId)->get();
            //     $departments = Department::where('company_id', $companyId)->get();

            //     return response()->json(['applications' => $applications, 'categories' => $categories, 'departments' => $departments]);
            // } 
            else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('departments.add_edit_app_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('departments.departments_app', $pageData);
    }
    public function post_add_edit_departments_app(Request $request, $app_id = null)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|array',
            'department_id.*' => 'exists:departments,id',
            'app_id' => 'required|array',
            'app_id.*' => 'exists:company_applications_nonproductive,id',
            'status' => 'in:0,1',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:company_applications_categories,id',
            // Add any other validation rules as needed
        ]);
        // dd($validator);
        if ($validator->fails()) {
            Log::error('Validation Errors: ' . json_encode($validator->errors()->all()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        $flag = $user->is_super_admin;

        try {
            // Save or update the data based on whether it's an edit or add operation
            foreach (
                $request->input('department_id') as $key => $departmentId) {
                $appId = $request->input('app_id')[$key];
                $status = $request->input('status')[$key];
                $categoryId = $request->input('category_id')[$key];
                if (!empty($app_id)) {
                    // Edit operation
                    $app = DepartmentNonProductiveApp::findOrFail($app_id);
                    // Update app details
                    $app->first()->update([
                        'department_id' => $departmentId,
                        'app_id' => $appId,
                        'status' => $status,
                        'category_id' => $categoryId,
                        // Update other fields as needed
                    ]);

                    $message = 'Department app details updated successfully.';
                } else {
                    // Add operation
                    $appData = [
                        'department_id' => $departmentId,
                        'app_id' => $appId,
                        'status' => $status,
                        'category_id' => $categoryId,
                        // Add other fields as needed
                    ];

                    // Include company_id only for super admin users
                    if ($flag) {
                        $appData['company_id'] = $request->input('company_id');
                        // Fetch category_id based on the selected app_id
                        $category_id = CompanyApplicationsNonProductive::findOrFail($request->input('app_id'))->category_id;
                        $appData['category_id'] = $category_id;
                    } else {
                        $appData['company_id'] = $user->company_id;
                        // Fetch category_id based on the selected app_id
                        $category_id = CompanyApplicationsNonProductive::findOrFail($request->input('app_id'))->category_id;
                        $appData['category_id'] = $category_id;
                    }

                    dd($appData['company_id']);

                    DepartmentNonProductiveApp::insert($appData);

                    $message = 'Department app details added successfully.';
                }
            }
            // Redirect to the view with a success message
            return redirect('/departments_app')->with('success', $message);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error("Error processing department app details: " . $e->getMessage());

            // Handle exceptions (e.g., log, show error message)
            return redirect()->back()->with('error', 'An error occurred while saving department app details.')->withInput();
        }
    }
    public function getCompanyData(Request $request, $companyId)
    {
        $applications = CompanyApplicationsNonProductive::where('company_id', $companyId)->get();
        $categories = CompanyApplicationsCategory::where('company_id', $companyId)->get();
        $departments = Department::where('company_id', $companyId)->get();

        $data = [
            'applications' => $applications,
            'categories' => $categories,
            'departments' => $departments,
        ];

        return response()->json($data);
    }
    public function updateStatus(Request $request)
    {
        $applicationId = $request->input('application_id');
        $status = $request->input('status');
        // Update the status in the database
        DB::table('department_non_productive_apps')
            ->where('id', $applicationId)
            ->update(['status' => $status]);

        return response()->json(['message' => 'Status updated successfully']);
    }
    public function softDeleteDepartmentApp(Request $request)
    {
        $applicationId = $request->input('application_id');

        // Update the active status in the database (soft delete)
        DB::table('department_non_productive_apps')
            ->where('id', $applicationId)
            ->update(['active' => 0]);

        return response()->json(['message' => 'Record deleted successfully']);
    }


    public function departments_employees()
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        // Fetch all departments with their employees
        $pageData['employeeWiseProductiveApps'] = EmployeeWiseProductiveApp::with(['employee', 'company', 'app', 'category'])->get();

        // Pass the departments to the view
        return view('departments.departments_employees', $pageData);
    }
    public function updateStatusEmpApp(Request $request)
    {
        $applicationId = $request->input('application_id');
        $status = $request->input('status');
        // Update the status in the database
        DB::table('employee_wise_productive_apps')
            ->where('id', $applicationId)
            ->update(['status' => $status]);

        return response()->json(['message' => 'Status updated successfully']);
    }
    public function softDeleteEmployeeApp(Request $request)
    {
        $applicationId = $request->input('application_id');

        // Update the active status in the database (soft delete)
        DB::table('employee_wise_productive_apps')
            ->where('id', $applicationId)
            ->update(['active' => 0]);

        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function add_edit_departments_employees(Request $request, $employee_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData = [];
        $pageData['flag'] = $flag;
        $pageData['edit_employee_details'] = false;
        $pageData['onmodal'] = false;

        $pageData['departments'] = Department::all();
        $pageData['companies'] = Company::all();
        $pageData['applications'] = CompanyApplicationsNonProductive::all();

        $employeeQuery = DB::table('employee_wise_productive_apps')
            ->select(
                'employee_wise_productive_apps.*',
                'employees.name as employee_name',
                'companies.company_name',
                'company_applications_nonproductive.app_name',
                'company_applications_nonproductive.category_id'
            )
            ->join('employees', 'employee_wise_productive_apps.employee_id', '=', 'employees.id')
            ->join('companies', 'employee_wise_productive_apps.company_id', '=', 'companies.id')
            ->join('company_applications_nonproductive', 'employee_wise_productive_apps.app_id', '=', 'company_applications_nonproductive.id');
        $pageData['employees'] = $employeeQuery->get();
        // Pass the user's company ID to the view
        $pageData['userCompanyId'] = $user->company_id;
        if (!$flag) {
            // Normal user - filter by their own company
            $employeeQuery->where('employee_wise_productive_apps.company_id', '=', $user->company_id);
            // Pass the user's company ID to the view
            $pageData['userCompanyId'] = $user->company_id;
        }

        if (!empty($employee_id)) {
            $employee_details = $employeeQuery
                ->where('employee_wise_productive_apps.id', $employee_id)
                ->first();

            $pageData['employee_details'] = $employee_details;
            $pageData['edit_employee_details'] = true;
        }

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_employee") {
                $pageData['onmodal'] = true;
                $modal_content = view('departments.employee_details_view', $pageData)->render();
                return $modal_content;
            } else {
                $pageData['onmodal'] = true;
                $modal_content = view('departments.employeeApps_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('departments.departments_employees', $pageData);
    }

    public function getEmpCompanyData(Request $request, $companyId)
    {
        $employees = Employee::where('company_id', $companyId)->get();
        $applications = CompanyApplicationsNonProductive::where('company_id', $companyId)->get();
        $categories = CompanyApplicationsCategory::where('company_id', $companyId)->get();
        $departments = Department::where('company_id', $companyId)->get();
        $data = [
            'applications' => $applications,
            'employees' => $employees,
            'categories' => $categories,
            'departments' => $departments,
        ];
        return response()->json($data);
    }
    public function post_add_edit_departments_employees(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;

        $rules = [
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
            'app_id' => 'required|exists:company_applications_nonproductive,id',
            // Add other validation rules as needed
        ];
        // Add unique validation rule for employee, company, and app combination conditionally
        if ($request->has('employee_id')) {
            $rules['employee_id'] = Rule::unique('employee_wise_productive_apps')
                ->where('company_id', $request->input('company_id'))
                ->where('app_id', $request->input('app_id'));
        }
        // Validate the request
        $request->validate($rules);

        // Extract form data
        $employeeId = $request->input('employee_id');
        $companyId = $request->input('company_id');
        $appId = $request->input('app_id');
        // Extract other form data as needed

        // Additional logic for non-super admin users
        if (!$flag) {
            // Ensure that the user can only modify records for their own company
            if ($companyId != $user->company_id) {
                // Handle unauthorized access
                abort(403, 'Unauthorized action.');
            }
        }

        // Save or update the record
        if ($request->has('edit_employee_id')) {
            // Editing an existing record
            $editEmployeeId = $request->input('edit_employee_id');

            DB::table('employee_wise_productive_apps')
                ->where('id', $editEmployeeId)
                ->update([
                    'employee_id' => $employeeId,
                    'company_id' => $companyId,
                    'app_id' => $appId,
                    // Update other fields as needed
                ]);

            $message = 'Employee record updated successfully.';
        } else {
            // Adding a new record
            DB::table('employee_wise_productive_apps')->insert([
                'employee_id' => $employeeId,
                'company_id' => $companyId,
                'app_id' => $appId,
                // Add other fields as needed
            ]);

            $message = 'Employee record added successfully.';
        }

        return redirect()->route('departments_employees')->with('success', $message);
    }    

    // public function post_add_edit_departments_employees(Request $request)
    // {
    //     $user = auth()->user();
    //     $flag = $user->is_super_admin;

    //     // Define validation rules
    //     $rules = [
    //         'employee_id' => 'required|array',
    //         'employee_id.*' => 'exists:employees,id',
    //         'company_id' => 'required|exists:companies,id',
    //         'app_id' => 'required|array',
    //         'app_id.*' => 'exists:company_applications_nonproductive,id',
    //         'department_id' => 'required|array',
    //         'department_id.*' => 'exists:departments,id',
    //         'category_id' => 'required|array',
    //         'category_id.*' => 'exists:company_applications_categories,id',
    //         // Add other validation rules as needed
    //     ];

    //     // Add unique validation rule for employee, company, and app combination conditionally
    //     if ($request->has('employee_id')) {
    //         $rules['employee_id'] = Rule::unique('employee_wise_productive_apps')
    //             ->where('company_id', $request->input('company_id'))
    //             ->whereIn('app_id', $request->input('app_id'))
    //             ->whereIn('department_id', $request->input('department_id'))
    //             ->whereIn('category_id', $request->input('category_id'));
    //     }

    //     // Validate the request
    //     $validator = \Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         Log::error('Validation Errors: ' . json_encode($validator->errors()->all()));
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Extract form data
    //     $employeeIds = $request->input('employee_id');
    //     $companyId = $request->input('company_id');
    //     $appIds = $request->input('app_id');
    //     $departmentIds = $request->input('department_id');
    //     $categoryIds = $request->input('category_id');
    //     // Extract other form data as needed

    //     // Convert arrays to strings
    //     $employeeIdsString = implode(',', $employeeIds);
    //     $appIdsString = implode(',', $appIds);
    //     $departmentIdsString = implode(',', $departmentIds);
    //     $categoryIdsString = implode(',', $categoryIds);

    //     // Additional logic for non-super admin users
    //     if (!$flag) {
    //         // Ensure that the user can only modify records for their own company
    //         if ($companyId != $user->company_id) {
    //             // Handle unauthorized access
    //             abort(403, 'Unauthorized action.');
    //         }
    //     }

    //     try {
    //         // Save or update the data based on whether it's an edit or add operation
    //         if ($request->has('edit_employee_id')) {
    //             // Editing an existing record
    //             $editEmployeeId = $request->input('edit_employee_id');

    //             DB::table('employee_wise_productive_apps')
    //                 ->where('id', $editEmployeeId)
    //                 ->update([
    //                     'employee_id' => $employeeIdsString,
    //                     'company_id' => $companyId,
    //                     'app_id' => $appIdsString,
    //                     'department_id' => $departmentIdsString,
    //                     'category_id' => $categoryIdsString,
    //                     // Update other fields as needed
    //                 ]);

    //             $message = 'Employee record updated successfully.';
    //         } else {
    //             // Adding a new record
    //             DB::table('employee_wise_productive_apps')->insert([
    //                 'employee_id' => $employeeIdsString,
    //                 'company_id' => $companyId,
    //                 'app_id' => $appIdsString,
    //                 'department_id' => $departmentIdsString,
    //                 'category_id' => $categoryIdsString,
    //                 // Add other fields as needed
    //             ]);

    //             $message = 'Employee record added successfully.';
    //         }

    //         // Redirect to the view with a success message
    //         return redirect()->route('departments_employees')->with('success', $message);
    //     } catch (\Exception $e) {
    //         // Log the exception for debugging
    //         Log::error("Error processing employee record: " . $e->getMessage());

    //         // Handle exceptions (e.g., log, show error message)
    //         return redirect()->back()->with('error', 'An error occurred while saving employee record.')->withInput();
    //     }
    // }
}
