<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;
use Psy\Readline\Hoa\Console;

class EmployeeManagementController extends Controller
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

    public function employees($comp_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = "employees";

        $company_id = $user->company_id;
        $liveEmployeesCount = Employee::from('employees as emp')
            ->join('tracker_sessions as ts', 'emp.id', 'ts.employee_id')
            ->where('emp.active', 1)
            ->where('ts.is_active', 1)
            ->when($flag != 1, function ($query) use ($user) {
                return $query->where('emp.company_id', $user->company_id);
            })
            ->count();
        $employees = Employee::select('employees.*', 'com.company_name')
            ->join('companies as com', 'employees.company_id', 'com.id')
            ->where('employees.active', '!=', 2);
        if ($flag != 1 || !empty($comp_id)) {

            if (!empty($comp_id)) {
                $company_id = $comp_id;
                $pageData['prev_page_id'] = $company_id;
            }

            $employees = $employees->where('employees.company_id', $company_id);
        }

        $employees = $employees->get();

        $pageData['employees'] = $employees;
        $pageData['liveEmployeesCount'] = $liveEmployeesCount;
        return view('employees.employees', $pageData);
    }

    public function add_edit_employee(Request $request, $emp_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData = [];
        $pageData['flag'] = $flag;
        $pageData['company_id'] = $user->company_id;
        $pageData['edit_emp_details'] = false;
        $pageData['onmodal'] = false;
        $settings = $this->settings;

        if ($flag == 1) {
            $companies = Company::where('active', 1)->get();
            $pageData['companies'] = $companies;
        }
        // Fetch departments for both add and edit scenarios
        $departments = Department::all();
        $pageData['departments'] = $departments;

        if (!empty($emp_id)) {
            // $emp_details = Employee::where('id', $emp_id)->first();
            // Use a join to retrieve data from both employees and departments tables
            $emp_details = Employee::join('departments', 'employees.department_id', '=', 'departments.id')
                ->select('employees.*', 'departments.department_name as department_name') // Include other department fields as needed
                ->where('employees.id', $emp_id)
                ->first();
            // Fetch departments for both add and edit scenarios
            $departments = Department::all();
            $pageData['departments'] = $departments;
            $pageData['company_id'] = $emp_details->company_id;
            $pageData['emp_details'] = $emp_details;
            $pageData['edit_emp_details'] = true;

            foreach ($settings as $key => $val) {
                if (isset($emp_details->$key)) {
                    $settings[$key]['value'] = $emp_details->$key;
                }
            }
        }

        $pageData['settings'] = $settings;

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_employee") {
                $pageData['onmodal'] = true;
                $modal_content = view('employees.employee_details_view', $pageData)->render();
                return $modal_content;
            } else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('employees.add_edit_employee_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('employees.add_edit_employee', $pageData);
    }

    public function post_add_edit_employee(Request $request, $emp_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $settings = $this->settings;

        $email = $request->email;
        $company_id = $request->company_id;
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'digits_between:5,10'],
            'profile_image' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('employees')->where(function ($query) use ($email, $company_id, $emp_id) {
                return $query->where('email', $email)
                    ->where('company_id', $company_id)
                    ->where('id', '!=', $emp_id)
                    ->where('active', '!=', 2);
            })],
        ], [
            'company_id' => "Plase Select Company",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $path = "";
        if ($request->has('profile_image') && !empty($request->profile_image)) {
            $path = upload_picture($request->profile_image);
        }

        $data = [
            'company_id' => $company_id,
            'created_by' => $user->id,
            'creator_type' => ($flag == 1) ? 1 : 0,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department_id' => $request->department_id,
        ];

        if (!empty($path)) {
            $data['profile_pic'] = $path;
        }

        foreach ($settings as $key => $val) {
            if (in_array($key, array_keys($request->all()))) {
                if (isset($val['interval'])) {
                    $data[$key] = (!empty($request->$key)) ? $request->$key : 0;
                } else {
                    $data[$key] = 1;
                }
            } else {
                $data[$key] = 0;
            }
        }

        if (isset($data['company_id'])) {
            $total_employees = Employee::where('company_id', $data['company_id'])->where('active', '!=', 2)->count();
            Company::where('id', $data['company_id'])->update(['employees_count' => $total_employees]);
        }

        if (empty($emp_id)) {
            $data['password'] = bcrypt(123456);
            $newemp_id = Employee::insertGetId($data);
            $msg = "Employee added successfullY";
            return redirect()->back()->with('success_msg', $msg);
        } else {
            $employee = Employee::where('id', $emp_id)->first();

            if ($request->avatar_remove == 1) {
                $data['profile_pic'] = null;
                $old_path = $employee->profile_pic;
                unlink(public_path() . '/' . $old_path);
            }

            if (!empty($employee)) {
                Employee::where('id', $emp_id)->update($data);
                $msg = "Employee Updated successfullY";

                return redirect()->back()->with('success_msg', $msg);
            } else {
                $msg = "Something Went Wrong!";
                return redirect()->back()->with('error_msg', $msg);
            }
        }
    }
    public function live_employees(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "get_secret") {
                $jwt_token = generate_jwt_token($request->emp_id);

                return ['jwt_token' => $jwt_token];
            }
        }
        $liveEmployeesCount = Employee::from('employees as emp')
            ->join('tracker_sessions as ts', 'emp.id', 'ts.employee_id')
            ->where('emp.active', 1)
            ->where('ts.is_active', 1)
            ->when($flag != 1, function ($query) use ($user) {
                return $query->where('emp.company_id', $user->company_id);
            })
            ->count();

        $employees = Employee::from('employees as emp')
            ->select('emp.*', 'ts.started_at')
            ->where('emp.active', 1)
            ->join('tracker_sessions as ts', 'emp.id', 'ts.employee_id', 'ts.started_at')
            ->where('ts.is_active', 1);
        if ($flag != 1) {
            $employees = $employees->where('emp.company_id', $user->company_id);
        }
        $employees = $employees->get();
        $pageData['employees'] = $employees;
        $pageData['liveEmployeesCount'] = $liveEmployeesCount;
        return view('employees.live_employees', $pageData);
    }

    public function activity(Request $request, $employee_id)
    {
        $from = null;
        $to = null;
        if ($request->has('selectedDate')) {
            $selectedDate = $request->input('selectedDate');

            // Process the 'selectedDate' as needed
            // For example, you can split it into 'from' and 'to' dates
            list($from, $to) = explode(' - ', $selectedDate);
            // Format 'from' and 'to' to be in "Y-m-d" format
            $from = date("Y-m-d", strtotime($from));
            $to = date("Y-m-d", strtotime($to));
            // Add predefined times to 'from' and 'to' dates
            $from .= ' 00:00:00';
            $to .= ' 23:59:59';
        } else {
            // Set default values for the date range (for example, the current date)
            $from = now()->startOfDay()->toDateTimeString();
            $to = now()->endOfDay()->toDateTimeString();
        }

        // Debugging
        // Make an API request with the determined date range
        $response = Http::post("https://api.m360tracker.com/employee/getEmployeedetailsFull/{$employee_id}", [
            'from' => $from,
            'to' => $to,
        ]);
        $responseSS = Http::post("https://api.m360tracker.com/employee/getEmployeeCapturedData/{$employee_id}", [

            'from' => $from,
            'to' => $to,

        ]);
        $apiDataSS = $responseSS->json();
        $apiData = $response->json();

        $selectedHour = $request->input('selectedHour');
        // dd($selectedHour);
        // Filter screen captures by the selected hour
        if (!empty($selectedHour)) {
            $apiDataSS['data']['screenCapture'] = array_filter($apiDataSS['data']['screenCapture'], function ($capture) use ($selectedHour) {
                return date('H', strtotime($capture['activetimestamp'])) == $selectedHour;
            });
        }
        // dd($apiDataSS);
        if ($request->ajax()) {
            $html = view('employees.activity_body', ['apiData' => $apiData, 'apiDataSS' => $apiDataSS],)->render();
            $breadcrumb_id = isset($apiData['employeeDetail']['id']) ? $apiData['employeeDetail']['id'] : 'N/A';
            return ['html' => $html, 'breadcrumb_id' => $breadcrumb_id, 'selectedDate' => $selectedDate];
        }
        // dd($apiData);
        return view('employees.activity', ['apiData' => $apiData, 'apiDataSS' => $apiDataSS]);
    }
    public function activity_ss(Request $request, $employee_id)
    {
        $response = Http::post("https://api.m360tracker.com/employee/getEmployeeCapturedData/{$employee_id}", [

            "from" => "2023-11-03 00:00:00",
            "to" => "2023-11-03 23:59:59"

        ]);
        $apiData = $response->json();
        return view('employees.activity_ss', ['apiData' => $apiData, 'employee_id' => $employee_id]);
    }

    public function employees_api()
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $company_id = $user->company_id;
        // Logic for live employees count
        $liveEmployeesCount = Employee::from('employees as emp')
            ->join('tracker_sessions as ts', 'emp.id', 'ts.employee_id')
            ->where('emp.active', 1)
            ->where('ts.is_active', 1)
            ->when($flag != 1, function ($query) use ($user) {
                return $query->where('emp.company_id', $user->company_id);
            })
            ->count();

        // Calculate the current date and time
        $currentDateTime = now(); // You can use Carbon or any other method based on your application setup

        // Fetching data from the external API using POST method
        $response = Http::post('https://api.m360tracker.com/employee/getEmployeedetails', [
            'from' => $currentDateTime->startOfDay()->toDateTimeString(),
            'to'   => $currentDateTime->endOfDay()->toDateTimeString()
        ]);

        $apiData = $response->json();
        if ($apiData['message'] == 'success' && !empty($apiData['data'])) {
            $employees = $apiData['data'];
            // If the user is not a super admin, filter data based on company_id
            if ($flag != 1) {
                $employees = array_filter($employees, function ($employee) use ($user) {
                    return isset($employee['company_id']) && $employee['company_id'] == $user->company_id;
                });
            }

            foreach ($employees as $employee) {
                if (isset(
                    $employee['employee_id'],
                    $employee['employee_name'],
                    $employee['employee_email'],
                    $employee['employee_phone'],
                    $employee['company_name'],
                    $employee['department_id'],
                    $employee['session']['started_at']
                )) {
                    $id = $employee['employee_id'];
                    $name = $employee['employee_name'];
                    $email = $employee['employee_email'];
                    $phone = $employee['employee_phone'];
                    $company_name = $employee['company_name'];
                    $department_id = $employee['department_id'];
                    $department = Department::find($department_id);
                    if ($department) {
                        $department_name = $department->department_name;
                    } else {
                        $department_name = null; // Set a default value or handle as needed
                    }
                    $created_at = isset($employee['session']) ? $employee['session']['started_at'] : null;
                } else {
                    // Log an error or handle the case where the required keys are missing
                    Log::error('Missing required keys in employee data from the external API.');
                }

                // Do whatever processing you need here with the employee data
            }
        } else {
            Log::error('Failed to fetch employees from the external API.');
            $employees = []; // Empty array, since the API call failed.
        }

        return view('employees.employees', ['employees' => $employees, 'liveEmployeesCount' => $liveEmployeesCount, 'flag' => $flag]);
    }
}
