<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\MasterApplicationsCategory;
use App\Models\CompanyApplicationsCategory;
use App\Models\MasterApplicationsNonproductive;
use App\Models\CompanyApplicationsNonproductive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

class CompanyManagementController extends Controller
{
    public function companies(Request $request)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData['flag'] = $flag;
        $pageData['table_name'] = "companies";

        $companies = Company::where('active', '!=', 2)->get();

        $pageData['companies'] = $companies;

        return view('companies.companies', $pageData);
    }

    public function add_edit_company(Request $request, $comp_id = null)
    {
        $user = auth()->user();
        $flag = $user->is_super_admin;
        $pageData = [];
        $pageData['flag'] = $flag;
        $pageData['edit_comp_details'] = false;
        $pageData['onmodal'] = false;
        $pageData['time_zones'] = getTimezoneList();
        $pageData['datetimeformat'] = datetimeformat();

        if (!empty($comp_id)) {
            $comp_details = Company::where('id', $comp_id)->first();
            $pageData['comp_details'] = $comp_details;
            $pageData['edit_comp_details'] = true;
        }

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_company") {
                $pageData['onmodal'] = true;
                $modal_content = view('companies.company_details_view', $pageData)->render();
                return $modal_content;
            } else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('companies.add_edit_company_modal_content', $pageData)->render();
                return $modal_content;
            }
        }

        return view('companies.add_edit_company', $pageData);
    }

    public function post_add_edit_company(Request $request, $comp_id = null)
    {
        $validation_array = [
            'company_name' => ['required', 'string', 'max:255'],
            'company_website' => 'required',
            'about_company' => 'required',
            'company_address' => 'required',
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'numeric', 'digits_between:5,10'],
            'timezone' => 'required',
            'date_time_format' => 'required',
            'company_logo' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048']
        ];

        if (empty($comp_id)) {
            $validation_array['contact_email'] = ['required', 'string', 'email', 'max:255', 'unique:companies'];
        } else {
            $validation_array['contact_email'] = ['required', 'string', 'email', 'max:255', Rule::unique('companies')->ignore($comp_id)];
        }

        $validator = Validator::make($request->all(), $validation_array, [
            'company_name' => "Company Name Required",
            'website' => "Company web site is requied",
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

        $path = "";
        if ($request->has('company_logo') && !empty($request->company_logo)) {
            $path = upload_picture($request->company_logo);
        }

        $company_info = [
            'company_name' => $request->company_name,
            'company_website' => $request->company_website,
            'about_company' => $request->about_company,
            'company_address' => $request->company_address,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'timezone' => $request->timezone,
            'date_time_format' => $request->date_time_format,
            'active' => 1,
        ];

        if (empty($comp_id)) {

            $company_info['company_logo'] = (!empty($path)) ? $path : null;
            // Create the company without saving it yet
            $newCompany = new Company($company_info);
            // Save the company to get its ID
            $newCompany->save();
            $company_id = $newCompany->id;
            // Get the list of categories from master_applications_categories
            $categories = MasterApplicationsCategory::all();
            // Create an array to store the data for company_applications_categories
            $companyCategories = [];
            foreach ($categories as $category) {
                $companyCategories[] = [
                    'category_id' => $category->id,
                    'company_id' => $company_id,
                    'category_name' => $category->category_name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Insert the data into company_applications_categories
            CompanyApplicationsCategory::insert($companyCategories);
            // Get the list of nonproductive applications from master_applications_nonproductive
            $nonproductiveApplications = MasterApplicationsNonproductive::all();
            // Create an array to store the data for company_applications_nonproductive
            $companyNonproductiveApplications = [];
            foreach ($nonproductiveApplications as $nonproductiveApplication) {
                $companyNonproductiveApplications[] = [
                    'company_id' => $company_id,
                    'app_name' => $nonproductiveApplication->app_name,
                    'description' => $nonproductiveApplication->description,
                    'category_id' => $nonproductiveApplication->category_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'status' => '0', // You can set the default status here
                ];
            }
            // Insert data into company_applications_nonproductive table
            CompanyApplicationsNonproductive::insert($companyNonproductiveApplications);

            // Update category_id in company_applications_nonproductive based on company_applications_categories
            // CompanyApplicationsNonproductive::join('company_applications_categories', function ($join) use ($company_id) {
            //     $join->on('company_applications_nonproductive.category_id', '=', 'company_applications_categories.category_id')
            //         ->where('company_applications_categories.company_id', '=', $company_id);
            // })
            //     ->where('company_applications_nonproductive.company_id', '=', $company_id)
            //     ->update(['company_applications_nonproductive.category_id' => DB::raw('company_applications_categories.id')]);



            $all_contact_emails = Company::where('active', '!=', 2)->get();
            $existing_company = true;
            $company_id = 0;

            foreach ($all_contact_emails as $val) {
                $company_email_domain = explode('@', $val->contact_email);
                if ($email_domain[1] == $company_email_domain[1]) {
                    $company_id = $val->id;
                }
            }

            if ($company_id == 0) {
                $existing_company = false;
                // $company_id = Company::insertGetId($company_info);

                $msg = "Company added successfullY";

                return redirect()->back()->with('success_msg', $msg);
            } else {
                unlink(public_path() . '/' . $path);
                return redirect()->back()->with('error_msg', 'Company Already exists');
            }
        } else {
            $company = Company::where('id', $comp_id)->first();
            if ($request->avatar_remove == 1) {
                $company_info['company_logo'] = null;
                $old_path = $company->company_logo;
                unlink(public_path() . '/' . $old_path);
            } elseif (!empty($path)) {
                $company_info['company_logo'] = $path;
            }

            if (!empty($company)) {
                Company::where('id', $comp_id)->update($company_info);
                $msg = "Company Details Updated successfullY";

                return redirect()->back()->with('success_msg', $msg);
            } else {
                $msg = "Something Went Wrong!";
                return redirect()->back()->with('error_msg', $msg);
            }
        }
    }

    public function categories()
    {
        $categories = MasterApplicationsCategory::all();
        $pageData['categories'] = $categories;
        return view('companies.master_categories', $pageData);
    }

    public function add_edit_categories(Request $request, $category_id = null)
    {
        $pageData = [];
        $pageData['edit_category_details'] = false;

        // If $category_id is provided, fetch category details for editing
        if (!empty($category_id)) {
            $category_details = MasterApplicationsCategory::find($category_id);
            $pageData['category_details'] = $category_details;
            $pageData['edit_category_details'] = true;
        }

        if ($request->ajax()) {
            // Check if it's an AJAX request for modal content
            $pageData['onmodal'] = true;
            $modal_content = view('companies.add_edit_category_modal_content', $pageData)->render();
            return $modal_content;
        }

        // For non-AJAX requests, return the main view
        $categories = MasterApplicationsCategory::all();
        $pageData['categories'] = $categories;
        return view('companies.master_categories', $pageData);
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
            $category = MasterApplicationsCategory::find($category_id);

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
            MasterApplicationsCategory::create([
                'category_name' => $request->input('category_name'),
                // Add other fields as needed
            ]);

            return redirect()->back()->with('success_msg', 'Category added successfully');
        }
    }

    public function delete_category(Request $request, $category_id)
    {
        $category = MasterApplicationsCategory::find($category_id);

        if (!$category) {
            // Handle the case where the category with the given ID is not found
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        // Delete the category
        $category->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success_msg', 'Category deleted successfully');
    }



    public function master_application(Request $request)
    {
        $master_application = MasterApplicationsNonproductive::join('master_applications_categories', 'master_applications_nonproductive.category_id', '=', 'master_applications_categories.id')
            ->select('master_applications_nonproductive.*', 'master_applications_categories.category_name')
            ->get();

        $pageData['master_application'] = $master_application;

        return view('applications.master_application', $pageData);
    }


    public function add_edit_master_application(Request $request, $app_id = null)
    {
        $categories = MasterApplicationsCategory::all();
        $pageData['categories'] = $categories;
        $pageData['edit_app_details'] = false;
        $master_application = MasterApplicationsNonproductive::join('master_applications_categories', 'master_applications_nonproductive.category_id', '=', 'master_applications_categories.id')
            ->select('master_applications_nonproductive.*', 'master_applications_categories.category_name')
            ->get();

        $pageData['master_application'] = $master_application;

        if (!empty($app_id)) {
            $app_details = MasterApplicationsNonproductive::find($app_id);
            $pageData['app_details'] = $app_details;
            $pageData['edit_app_details'] = true;
        }

        if ($request->ajax()) {
            if ($request->has('page') && $request->page == "view_application") {
                $pageData['onmodal'] = true;
                $modal_content = view('applications.application_details_view', $pageData)->render();
                return $modal_content;
            } else {
                // Return the necessary data for the modal
                $pageData['onmodal'] = true;
                $modal_content = view('applications.add_edit_Master_application_modal', $pageData)->render();
                return $modal_content;
            }
        }

        return view('applications.master_application', $pageData);
    }

    public function post_add_edit_master_application(Request $request, $app_id = null)
    {
        $validation_rules = [
            'app_name' => ['required', 'string', 'max:255'],
            'category_id' => 'required|exists:master_applications_categories,id',
            'description' => 'required',
            // Add more validation rules as needed
        ];

        $validator = Validator::make($request->all(), $validation_rules, [
            'app_name.required' => 'Application name is required',
            // Add more custom error messages as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        // Check if it's an edit request
        if (!empty($app_id)) {
            $app = MasterApplicationsNonproductive::find($app_id);

            if (!$app) {
                // Handle the case where the application with the given ID is not found
                return redirect()->back()->withErrors(['error' => 'Application not found'])->withInput($request->input());
            }

            // Update the existing application
            $app->update([
                'app_name' => $request->input('app_name'),
                'category_id' => $request->input('category_id'),
                'description' => $request->input('description'),
                // Update other fields as needed
            ]);

            return redirect()->back()->with('success_msg', 'Application updated successfully');
        } else {
            // It's an add request, create a new application
            MasterApplicationsNonproductive::create([
                'app_name' => $request->input('app_name'),
                'category_id' => $request->input('category_id'),
                'description' => $request->input('description'),
                // Add other fields as needed
            ]);

            return redirect()->back()->with('success_msg', 'Application added successfully');
        }
    }
    public function delete_application($app_id)
    {
        $application = MasterApplicationsNonproductive::find($app_id);

        if (!$application) {
            // Handle the case where the application with the given ID is not found
            return redirect()->back()->withErrors(['error' => 'Application not found']);
        }

        // Delete the application
        $application->delete();

        return redirect()->back()->with('success_msg', 'Application deleted successfully');
    }
}
