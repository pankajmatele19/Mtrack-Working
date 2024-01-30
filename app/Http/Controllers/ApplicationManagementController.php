<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Application;
use App\Models\CompanyApplicationsCategory;
use App\Models\CompanyTeamRole;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeWiseProductiveApp;
use App\Models\SuperadminTeamRole;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ApplicationManagementController extends Controller
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
    public function applications(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = "applications";
        $company_id = $user->company_id;

        $applications = DB::table('company_applications_nonproductive as cappnp')
            ->join('company_applications_categories as mappc', 'cappnp.category_id', '=', 'mappc.id')
            ->join('companies', 'cappnp.company_id', '=', 'companies.id')
            ->select('cappnp.*', 'mappc.category_name', 'companies.company_name');

        if ($flag != 1) {
            $applications = $applications->where('cappnp.company_id', $company_id);
        }

        if ($request->ajax()) {
            if ($request->has('customParam') && $request->customParam == "applications_table") {
                // $columns=['cappnp.'];
                if ($request->has('search')) {
                    $name = $request->search;
                    if (isset($name['value'])) {

                        $name = $name['value'];
                        $applications = $applications->where(function ($query) use ($name) {
                            $query->where('companies.company_name', 'like', '%' . $name . '%');
                            // ->orWhere('jp.job_title', 'like', '%' . $name . '%');
                        });
                    }
                }

                // if ($request->has('order')) {
                //     $order = $request->input('order')[0];
                //     $orderByColumnIndex = intval($order['column']); // Get the column index
                //     $orderDirection = $order['dir'];

                //     $orderByColumnName = $columns[$orderByColumnIndex];
                //     $applications = $applications->orderBy($orderByColumnName, $orderDirection);
                // } else {
                $applications = $applications->orderBy('cappnp.id', 'desc');
                // }

                $total_applications = $applications->count();

                $limit = $request->input('length');
                $start = $request->input('start');

                $applications = $applications->offset($start)
                    ->limit($limit)
                    ->get();


                $data = [];
                foreach ($applications->where('status', 1) as $key => $val) {

                    // dd($val->id);

                    $data[] = [

                        // 'is_nonproductive' => view('applications.switch', compact('val'))->render(),
                        'app_name' => "<span>" . (isset($val->app_name) ? $val->app_name : '-') . "</span><br>",
                        'description' => "<span>" . (isset($val->description) ? $val->description : '-') . "</span><br>",
                        'company_name' => "<span>" . (isset($val->company_name) ? $val->company_name : '-') . "</span><br>",

                        'app_id' => "<span>" . (isset($val->id) ? $val->id : '-') . "</span><br>",

                        'category_name' => "<span>" . (isset($val->category_name) ? $val->category_name : '-') . "</span><br>",

                        // 'make_productive' => '<button type="button" class="btn btn-primary btn-sm make-productive" data-toggle="modal" data-target="#myModal data-id="' . (isset($val->app_name) ? $val->app_name : '') . '">Make Productive</button>',

                        'action' => view('applications.actions', compact('val'))->render(),


                    ];

                    // dd($data);

                }

                $jsonResponse = [
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => intval($total_applications),
                    'recordsFiltered' => intval($total_applications),
                    'data' => $data,
                ];

                return response()->json($jsonResponse);
            }

        }



        // $app_id = $applications->select('cappnp.id')->get();
        // dd($app_id);

        $departments = DB::table('departments as dp')
            ->join('employees as emp', 'emp.company_id', '=', 'dp.company_id')
            ->select('dp.*')
            ->distinct()
            ->get();
        // dd($departments);

        $employees = DB::table('employees as emp')
            ->join('departments as dp', 'emp.company_id', '=', 'dp.company_id')
            ->select('emp.name')
            ->distinct()
            ->get();

        $pageData['applications'] = $applications;
        $pageData['departments'] = $departments;
        // $pageData['emp'] = $employees;

        // dd($pageData);
        return view('applications.applications', $pageData);
    }



    public function updateStatus(Request $request)
    {
        $applicationId = $request->input('application_id');
        $status = $request->input('status');

        // Update the status in the database
        DB::table('company_applications_nonproductive')
            ->where('id', $applicationId)
            ->update(['status' => $status]);

        return;
    }

    // public function getDepartments(Request $request, $department)
    // {
    //     // Fetch employees based on the selected department
    //     $departments = Department::where('department_name', $department)->pluck('name', 'id');

    //     return response()->json($departments);
    // }

    // public function getEmployees(Request $request, $dpid, $depts)
    // {



    //     if ($dpid == 'alldept') {
    //         $employees = DB::table('employees as emp')
    //             ->select('emp.*')
    //             ->get();

    //         dd($employees);
    //     }


    //     elseif (!empty($depts)) {
    //         // Convert comma-separated string to an array
    //         $selectedDepartments = explode(',', $depts);

    //         // dd($selectedDepartments);

    //         // Fetch employees based on the selected departments
    //         $employees = DB::table('employees as emp')
    //             ->select('emp.name')
    //             ->whereIn('emp.department_id', $selectedDepartments)
    //             ->pluck('name');
    //     } 
    //     else {

    //         // Fetch employees based on the selected department
    //         $departments = DB::table('departments as dp')
    //             ->join('employees as emp', 'emp.company_id', '=', 'dp.company_id')
    //             ->select('dp.id')
    //             ->where('dp.id', '=', $dpid)
    //             ->distinct()
    //             ->pluck('id');
    //         // dd($departments);



    //         $employees = DB::table('employees as emp')
    //             ->select('emp.name')
    //             ->whereIn('emp.department_id', $departments)
    //             ->pluck('name');

    //         // dd($employees);


    //     }
    //     return response()->json($employees);
    // }

    public function getEmployees(Request $request, $dpid, $depts)
    {
        if ($dpid === 'alldept') {
            $employees = DB::table('employees as emp')
                ->select('emp.*', 'dp.department_name')
                ->join('departments as dp', 'emp.department_id', '=', 'dp.id')
                ->get();

            return response()->json($employees);
        } elseif (!empty($depts)) {
            // Convert comma-separated string to an array
            $selectedDepartments = explode(',', $depts);

            // Fetch employees based on the selected departments
            $employees = DB::table('employees as emp')
                ->select('emp.name', 'dp.department_name')
                ->join('departments as dp', 'emp.department_id', '=', 'dp.id')
                ->whereIn('emp.department_id', $selectedDepartments)
                ->get();

            return response()->json($employees);
        } else {
            // Fetch employees based on the selected department
            $departments = DB::table('departments as dp')
                ->join('employees as emp', 'emp.company_id', '=', 'dp.company_id')
                ->select('dp.id', 'dp.department_name')
                ->where('dp.id', '=', $dpid)
                ->distinct()
                ->pluck('dp.id');

            $employees = DB::table('employees as emp')
                ->select('emp.name', 'dp.department_name')
                ->join('departments as dp', 'emp.department_id', '=', 'dp.id')
                ->whereIn('emp.department_id', $departments->id)
                ->get();

            return response()->json($employees);
        }
    }

    public function make_productive(Request $request)
    {
        // dd($request->all());

        
        $prodapp_emp = new EmployeeWiseProductiveApp();
        
        $employees = DB::table('employees as emp')
            ->select('emp.id', 'emp.company_id')
            ->whereIn('emp.name', (array) $request->employee) // Ensure it's an array
            ->get();

        // dd($employees);

        foreach ($employees as $employee) {
            $prodapp_emp = new EmployeeWiseProductiveApp();

            $prodapp_emp->employee_id = $employee->id;
            $prodapp_emp->company_id = $employee->company_id;
            $prodapp_emp->app_id = $request->input('appid');

            // Save the application for each employee
            $prodapp_emp->save();
        }

        return redirect()->route('applications')->with('success', 'Applications saved successfully!');
    }




    public function getCategories($companyId)
    {
        // Fetch categories based on the $companyId
        $categories = CompanyApplicationsCategory::where('company_id', $companyId)->get();

        return response()->json(['categories' => $categories]);
    }
    public function add_edit_application(Request $request, $app_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData = [];
        $pageData['flag'] = $flag;
        $pageData['company_id'] = $user->company_id;

        // Check if the user is a super admin
        if ($flag) {
            $pageData['company_name'] = 'Select Company'; // Set a default value for super admins
            $companies = Company::where('active', 1)->get();
        } else {
            // Assuming you have a 'companies' table and a 'company_name' column
            $company = Company::find($user->company_id);
            $pageData['company_name'] = $company->company_name;
            $companies = collect([$company]); // Convert the single company to a collection for consistency
        }

        $pageData['edit_app_details'] = false;
        $pageData['onmodal'] = false;
        $pageData['companies'] = $companies;

        // Assuming you have an 'applications' table
        $applications = Application::select(
            'company_applications_nonproductive.*',
            'company_applications_categories.category_name',
            'companies.company_name'
        )
            ->join('company_applications_categories', 'company_applications_nonproductive.category_id', '=', 'company_applications_categories.id')
            ->join('companies', 'company_applications_nonproductive.company_id', '=', 'companies.id')
            ->when(!$flag, function ($query) use ($pageData) {
                // If not a super admin, restrict to the user's company
                $query->where('company_applications_nonproductive.company_id', $pageData['company_id']);
            })
            ->get();
        // dd($applications);
        // Fetch categories for applications directly from the 'applications' table
        $categories = DB::table('company_applications_nonproductive')
            ->join('company_applications_categories', 'company_applications_nonproductive.category_id', '=', 'company_applications_categories.id')
            ->select('company_applications_nonproductive.category_id', 'company_applications_categories.category_name')
            ->distinct()
            ->get();

        // dd($categories);

        $pageData['categories'] = $categories;

        if (!empty($app_id)) {
            $app_details = $applications->where('id', $app_id)->first();
            $pageData['category_id'] = $app_details->category_id;
            $pageData['app_details'] = $app_details;
            $pageData['edit_app_details'] = true;

            // Assuming you have corresponding fields in the 'applications' table
            // Adjust these fields based on your actual table structure
            $pageData['app_name'] = $app_details->app_name;
            $pageData['app_description'] = $app_details->app_description;
            // Add more fields as needed
        }

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_application") {
                $pageData['onmodal'] = true;
                $modal_content = view('applications.application_details_view', $pageData)->render();
                return $modal_content;
            } else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('applications.add_edit_application_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('applications.edit', $pageData);
    }

    public function post_add_edit_application(Request $request, $app_id = null)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:company_applications_categories,id',
            'company_id' => 'required|exists:companies,id', // Assuming 'companies' is your companies table
            // Add more validation rules for other fields as needed
        ]);

        // Assuming you have an 'applications' table
        $application = new Application();

        // If editing, retrieve the existing application
        if (!empty($app_id)) {
            $application = Application::find($app_id);
        }

        // Assign form data to the application model
        $application->app_name = $request->input('name');
        $application->description = $request->input('description');
        $application->category_id = $request->input('category_id');
        // Set the company_id from the authenticated user
        $application->company_id = $request->input('company_id');
        $application->status = 0;

        // Add more fields as needed

        // Save the application
        $application->save();
        // Redirect back or to a different page after successful form submission
        return redirect()->route('applications')->with('success', 'Application saved successfully!');
    }
    public function softDeleteCompanyApp(Request $request)
    {
        $applicationId = $request->input('application_id');

        // Update the active status in the database (soft delete)
        DB::table('company_applications_nonproductive')
            ->where('id', $applicationId)
            ->update(['status' => 0]);

        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function categories()
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        if ($flag) {
            // Super admin - get all categories with company names
            $categories = CompanyApplicationsCategory::with('company')->get();
            // Retrieve unique companies from the categories
            // $companies = $categories->unique('company_id')->pluck('company');
        } else {
            // Normal user - filter by their own company
            $categories = CompanyApplicationsCategory::where('company_id', $user->company_id)->get();
            // Retrieve the user's company
            // $companies = CompanyApplicationsCategory::where('company_id', $user->company_id)->pluck('company');
        }

        $pageData['categories'] = $categories;

        // $pageData['companies'] = $companies;
        return view('applications.applications_categories', $pageData);
    }

    public function add_edit_categories(Request $request, $category_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['edit_category_details'] = false;

        // If $category_id is provided, fetch category details for editing
        if (!empty($category_id)) {
            $category_details = CompanyApplicationsCategory::find($category_id);
            $pageData['category_details'] = $category_details;
            $pageData['edit_category_details'] = true;
        }

        if ($request->ajax()) {
            // Check if it's an AJAX request for modal content
            $pageData['onmodal'] = true;
            $companies = DB::table('companies')

                ->select('companies.company_name')
                ->get();

            // dd($companies->toArray());

            $pageData['companies'] = $companies;
            $modal_content = view('applications.add_edit_category_modal_content', $pageData)->render();
            return $modal_content;
        }

        // For non-AJAX requests, return the main view
        $categories = CompanyApplicationsCategory::all();
        $pageData['categories'] = $categories;
        return view('applications.applications_categories', $pageData);
    }

    public function post_add_edit_categories(Request $request, $category_id = null)
    {
        $validation_rules = [
            'category_name' => ['required', 'string', 'max:255'],
            // Add more validation rules as needed
        ];

        $validator = Validator::make($request->all(), $validation_rules, [
            'category_name.required' => 'Category name is required',
            // Add more custom error messages as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        // Check if it's an edit request
        if (!empty($category_id)) {
            $category = CompanyApplicationsCategory::find($category_id);

            if (!$category) {
                // Handle the case where the category with the given ID is not found
                return redirect()->back()->withErrors(['error' => 'Category not found'])->withInput($request->input());
            }

            // Update the existing category
            $category->update([
                'category_name' => $request->input('category_name'),
                // Update other fields as needed
            ]);

            return redirect()->back()->with('success_msg', 'Category updated successfully');
        } else {
            // It's an add request, create a new category
            CompanyApplicationsCategory::create([
                'category_name' => $request->input('category_name'),
                // Add other fields as needed
            ]);

            return redirect()->back()->with('success_msg', 'Category added successfully');
        }
    }

    public function delete_category(Request $request, $category_id)
    {
        $category = CompanyApplicationsCategory::find($category_id);

        if (!$category) {
            // Handle the case where the category with the given ID is not found
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        // Delete the category
        $category->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success_msg', 'Category deleted successfully');
    }
}
