<?php

use App\Http\Controllers\CompanyManagementController;
use App\Http\Controllers\DashboardManagementController;
use App\Http\Controllers\EmployeeManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ApplicationManagementController;
use App\Http\Controllers\DepartmentManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::user()) {
        return redirect('dashboard');
    } else {
        return redirect('/sign_in');
    }
});

Route::get('/sign_in', [UserManagementController::class, 'sign_in'])->name('user.sign_in');
Route::post('/sign_in', [UserManagementController::class, 'sign_in_post'])->name('user.sign_in_post');
Route::get('/sign_up', [UserManagementController::class, 'sign_up'])->name('user.sign_up');
Route::post('/sign_up', [UserManagementController::class, 'sign_up_post'])->name('user.sign_up_post');
Route::get('/forgot_password', [UserManagementController::class, 'forgot_password'])->name('user.forgot_password');
Route::post('/forgot_password', [UserManagementController::class, 'forgot_password_post'])->name('user.forgot_password_post');
Route::get('/verify/{id}/{token}', [UserManagementController::class, 'verify']);
Route::get('/verify_otp', [UserManagementController::class, 'verify_otp'])->name('user.verify_otp');
Route::post('/verify_otp', [UserManagementController::class, 'verify_otp_post'])->name('user.verify_otp_post');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'is_superadmin'], function () {

        //company
        Route::get('/companies', [CompanyManagementController::class, 'companies'])->name('companies');
        Route::get('/company/add_new', [CompanyManagementController::class, 'add_edit_company'])->name('companies.add_company');
        Route::post('/company/add_new', [CompanyManagementController::class, 'post_add_edit_company'])->name('companies.post_add_company');
        Route::get('/company/edit/{comp_id}', [CompanyManagementController::class, 'add_edit_company'])->name('companies.edit_company');
        Route::post('/company/edit/{comp_id}', [CompanyManagementController::class, 'post_add_edit_company'])->name('companies.post_edit_company');


        Route::get('/categories', [CompanyManagementController::class, 'categories'])->name('categories');
        Route::get('/categories/add', [CompanyManagementController::class, 'add_edit_categories'])->name('add_edit_categories');
        Route::post('/categories/add', [CompanyManagementController::class, 'post_add_edit_categories'])->name('add_edit_categories');
        Route::get('/categories/edit/{category_id}', [CompanyManagementController::class, 'add_edit_categories'])->name('add_edit_categories');
        Route::post('/categories/edit/{category_id}', [CompanyManagementController::class, 'post_add_edit_categories'])->name('add_edit_categories');
        Route::get('/delete-category/{category_id}', [CompanyManagementController::class, 'delete_category'])->name('delete_category');


        Route::get('/master_application', [CompanyManagementController::class, 'master_application'])->name('master_application');
        Route::get('/master_application/add', [CompanyManagementController::class, 'add_edit_master_application'])->name('add_edit_master_application');
        Route::post('/master_application/add', [CompanyManagementController::class, 'post_add_edit_master_application'])->name('add_edit_master_application');
        Route::get('/master_application/edit/{app_id}', [CompanyManagementController::class, 'add_edit_master_application'])->name('add_edit_master_application');
        Route::post('/master_application/edit/{app_id}', [CompanyManagementController::class, 'post_add_edit_master_application'])->name('add_edit_master_application');
        Route::get('/delete-application/{app_id}', [CompanyManagementController::class, 'delete_application'])->name('delete_master_app');

        //superadmin users
        Route::get('/superadmin/users', [SuperAdminController::class, 'users_list'])->name('superadmin.users');
        Route::get('/superadmin/user/invite', [SuperAdminController::class, 'add_edit_user'])->name('superadmin.users.add_user');
        Route::post('/superadmin/user/invite', [SuperAdminController::class, 'post_add_edit_user'])->name('superadmin.users.post_add_user');
        Route::get('/superadmin/user/edit/{user_id}', [SuperAdminController::class, 'add_edit_user'])->name('superadmin.users.edit_user');
        Route::post('/superadmin/user/edit/{user_id}', [SuperAdminController::class, 'post_add_edit_user'])->name('superadmin.users.post_edit_user');

        //superadmin permissions
        Route::get('/superadmin/permissions', [SuperAdminController::class, 'permissions'])->name('superadmin.permissions');
        Route::get('/superadmin/permission/edit/{permission_id}', [SuperAdminController::class, 'permissions'])->name('superadmin.permission.edit');
        Route::post('/superadmin/permissions', [SuperAdminController::class, 'post_permissions'])->name('superadmin.post_permissions');

        //superadmin roles
        Route::get('/superadmin/roles', [SuperAdminController::class, 'roles'])->name('superadmin.roles');
        Route::post('/superadmin/add_new_role', [SuperAdminController::class, 'post_roles'])->name('superadmin.add_new_role');
        Route::post('/superadmin/roles', [SuperAdminController::class, 'post_roles'])->name('superadmin.post_roles');

        //company users
        Route::get('/users/{comp_id}', [UserManagementController::class, 'users_list'])->name('company.users');

        //company roles
        Route::get('/roles/{comp_id}', [RoleManagementController::class, 'roles'])->name('company.roles');

        //company employees
        Route::get('/employees/{comp_id}', [EmployeeManagementController::class, 'employees'])->name('company.employees');
    });

    Route::get('/sign_out', [UserManagementController::class, 'sign_out'])->name('user.sign_out');

    Route::get('/dashboard', [DashboardManagementController::class, 'dashboard'])->name('dashboard');

    // Route::get('/myprofile', [ProfileController::class, 'view_profile'])->name('myprofile');
    Route::get('/myprofile', [ProfileController::class, 'view_profile'])->name('myprofile.edit');
    Route::get('/company', [ProfileController::class, 'view_profile'])->name('myprofile.edit');
    Route::post('/myprofile', [ProfileController::class, 'update_profile'])->name('myprofile.update');
    Route::post('/company', [ProfileController::class, 'update_company'])->name('myprofile.company.update');

    Route::get('/users', [UserManagementController::class, 'users_list'])->name('users');
    Route::get('/user/invite', [UserManagementController::class, 'add_edit_user'])->name('users.add_user');
    Route::post('/user/invite', [UserManagementController::class, 'post_add_edit_user'])->name('users.post_add_user');
    Route::get('/user/edit/{user_id}', [UserManagementController::class, 'add_edit_user'])->name('users.edit_user');
    Route::post('/user/edit/{user_id}', [UserManagementController::class, 'post_add_edit_user'])->name('users.post_edit_user');

    Route::get('/roles', [RoleManagementController::class, 'roles'])->name('roles');
    Route::post('/add_new_role', [RoleManagementController::class, 'post_roles'])->name('add_new_role');
    Route::post('/roles', [RoleManagementController::class, 'post_roles'])->name('post_roles');

    Route::get('/departments', [DepartmentManagementController::class, 'departments'])->name('departments');
    Route::get('/superadmin/departments', [DepartmentManagementController::class, 'departments'])->name('departments');
    Route::get('/department/add', [DepartmentManagementController::class, 'add_edit_department'])->name('departments.add_department');
    Route::post('/department/add', [DepartmentManagementController::class, 'post_add_edit_department'])->name('departments.post_add_department');
    Route::get('/department/edit{dept_id}', [DepartmentManagementController::class, 'add_edit_department'])->name('departments.edit_department');
    Route::post('/department/edit{dept_id}', [DepartmentManagementController::class, 'post_add_edit_department'])->name('departments.post_edit_department');
    Route::get('/delete-department/{dept_id}', [DepartmentManagementController::class, 'delete_department'])->name('delete_department');


    Route::get('/departments_app', [DepartmentManagementController::class, 'departments_app'])->name('departments_app');
    Route::get('/departments_app/get-company-data/{companyId}', [DepartmentManagementController::class, 'getCompanyData'])->name('getCompanyData');
    Route::get('/departments_app/add', [DepartmentManagementController::class, 'add_edit_departments_app'])->name('add_edit_departments_app');
    Route::post('/departments_app/add', [DepartmentManagementController::class, 'post_add_edit_departments_app'])->name('post_add_edit_departments_app');
    Route::get('/departments_app/edit/{dept_id}', [DepartmentManagementController::class, 'add_edit_departments_app'])->name('add_edit_departments_app');
    Route::post('/departments_app/edit/{dept_id}', [DepartmentManagementController::class, 'post_add_edit_departments_app'])->name('post_add_edit_departments_app');
    Route::post('departments-applications/update-application-status', [DepartmentManagementController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/departments-applications/soft-delete-employee-app', [DepartmentManagementController::class, 'softDeleteDepartmentApp'])->name('softDeleteDepartmentApp');

    Route::get('/departments_employees', [DepartmentManagementController::class, 'departments_employees'])->name('departments_employees');
    Route::get('/departments_employees/get-employees-by-company/{companyId}', [DepartmentManagementController::class, 'getEmpCompanyData'])->name('get_employees_by_company');
    Route::get('/departments_employees/add', [DepartmentManagementController::class, 'add_edit_departments_employees'])->name('add_edit_departments_employees');
    Route::post('/departments_employees/add', [DepartmentManagementController::class, 'post_add_edit_departments_employees'])->name('post_add_edit_departments_employees');
    Route::get('/departments_employees/edit/{empApp_id}', [DepartmentManagementController::class, 'add_edit_departments_employees'])->name('add_edit_departments_employees');
    Route::post('/departments_employees/edit/{empApp_id}', [DepartmentManagementController::class, 'post_add_edit_departments_employees'])->name('post_add_edit_departments_employees');
    Route::post('/employees-applications/update-application-status', [DepartmentManagementController::class, 'updateStatusEmpApp'])->name('updateStatusEmpApp');
    Route::post('/employees-applications/soft-delete-employee-app', [DepartmentManagementController::class, 'softDeleteEmployeeApp'])->name('softDeleteEmployeeApp');

    Route::get('/permissions', [RoleManagementController::class, 'permissions'])->name('permissions');
    Route::get('/permission/edit/{permission_id}', [RoleManagementController::class, 'permissions'])->name('permission.edit');
    Route::post('/permissions', [RoleManagementController::class, 'post_permissions'])->name('post_permissions');

    Route::get('/employees', [EmployeeManagementController::class, 'employees_api'])->name('employees_api');
    Route::get('/employee/add_new', [EmployeeManagementController::class, 'add_edit_employee'])->name('employees.add_employee');
    Route::post('/employee/add_new', [EmployeeManagementController::class, 'post_add_edit_employee'])->name('employees.post_add_employee');
    Route::get('/employee/edit/{emp_id}', [EmployeeManagementController::class, 'add_edit_employee'])->name('employees.edit_employee');
    Route::post('/employee/edit/{emp_id}', [EmployeeManagementController::class, 'post_add_edit_employee'])->name('employees.post_edit_employee');
    Route::get('/employee/live_employees', [EmployeeManagementController::class, 'live_employees'])->name('employees.live_employees');
    Route::get('/employee/activity/{employee_id}', [EmployeeManagementController::class, 'activity'])->name('employees.activity');
    Route::post('/employee/activity/{employee_id}', [EmployeeManagementController::class, 'activity'])->name('employees.activity');
    Route::get('/employee/activity_ss/{employee_id}', [EmployeeManagementController::class, 'activity_ss'])->name('employees.activity_ss');



    Route::get('/applications', [ApplicationManagementController::class, 'applications'])->name('applications');
    Route::get('/superadmin/applications', [ApplicationManagementController::class, 'applications'])->name('applications');
    Route::post('/applications/update-application-status', [ApplicationManagementController::class, 'updateStatus'])->name('updateapplications');
    Route::get('/applications/update-application-status', [ApplicationManagementController::class, 'updateStatus'])->name('updateapplications');
    Route::get('categories/get-categories/{companyId}', [ApplicationManagementController::class, 'getCategories'])->name('getCategories');
    Route::get('/application/add', [ApplicationManagementController::class, 'add_edit_application'])->name('applications.add_application');
    Route::post('/application/add', [ApplicationManagementController::class, 'post_add_edit_application'])->name('applications.post_add_application');
    Route::get('/application/edit/{app_id}', [ApplicationManagementController::class, 'add_edit_application'])->name('applications.edit_application');
    Route::post('/application/edit/{app_id}', [ApplicationManagementController::class, 'post_add_edit_application'])->name('applications.post_edit_application');
    Route::post('/company-applications/soft-delete-company-app', [ApplicationManagementController::class, 'softDeleteCompanyApp'])->name('softDeleteCompanyApp');
    Route::get('/applications_categories', [ApplicationManagementController::class, 'categories'])->name('categories');
    Route::get('/applications_categories/add', [ApplicationManagementController::class, 'add_edit_categories'])->name('add_edit_categories');
    Route::post('/applications_categories/add', [ApplicationManagementController::class, 'post_add_edit_categories'])->name('add_edit_categories');
    Route::get('/applications_categories/edit/{category_id}', [ApplicationManagementController::class, 'add_edit_categories'])->name('add_edit_categories');
    Route::post('/applications_categories/edit/{category_id}', [ApplicationManagementController::class, 'post_add_edit_categories'])->name('add_edit_categories');
    Route::get('/delete-applications_category/{category_id}', [ApplicationManagementController::class, 'delete_category'])->name('delete_category');

    Route::post('/delete/record', function (Request $request) {
        $response = delete_record($request->all());
        return $response;
    })->name('employees.delete_employee');
});
