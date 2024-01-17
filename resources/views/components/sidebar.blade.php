@php
    $user = auth()->user();
    $flag = $user->is_super_admin;
@endphp
@php
    use App\Models\Employee;
    $liveEmployeesCount = Employee::from('employees as emp')
        ->join('tracker_sessions as ts', 'emp.id', 'ts.employee_id')
        ->where('emp.active', 1)
        ->where('ts.is_active', 1)
        ->count();
@endphp

<style>
    #kt_app_sidebar_logo {
        background-color: azure;
        border-right: 1px solid;
        border-color: #cadbf0;
    }

    #kt_app_sidebar_toggle {
        background-color: #3e97ff !important;
    }

    .app-sidebar-logo-default {
        height: 276px !important;
        margin-top: 40px;
        margin-left: -24px;
    }

    .app-sidebar-logo-minimize {
        height: 38px;
        margin-left: -10px;
    }
</style>
<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ url('/dashboard') }}">
            <img alt="Logo" src="assets/media/logos/mtrack1.png" class="app-sidebar-logo-default" />
            <img alt="Logo" src="assets/media/logos/shorticon.png" class="app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:
                if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
                    1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                    2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                    3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                    4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
                }
            -->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180" style="color: #ffff;">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ url('/dashboard') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-11 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Pages</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->
                    @if (isset($flag) && $flag == 1)
                        @php
                            $company_urls = [request()->is('users'), request()->is('roles'), request()->is('permissions'), request()->is('user/*'), request()->is('employees'), request()->is('employee/*')];
                            $request_url_team = [request()->is('users'), request()->is('roles'), request()->is('permissions'), request()->is('user/*')];
                        @endphp
                        <!--begin:Menu item Companies-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item {{ request()->is('companies') || request()->is('company/*') || in_array(Request::url(), $company_urls) ? 'here show' : '' }} menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-bank fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Companies</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div
                                class="menu-sub menu-sub-accordion {{ request()->is('company/*') || in_array(Request::url(), $company_urls) ? 'show' : '' }}">
                                <!--begin:Menu item Companies-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('companies') || request()->is('company/*') ? 'active' : '' }}"
                                        href="{{ url('/companies') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Companies</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <div data-kt-menu-trigger="click"
                                    class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Department Management</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('department') || request()->is('department/*') ? 'active' : '' }}"
                                                href="{{ url('/departments') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Departments</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item company roles-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('departments_app') ? 'active' : '' }}"
                                                href="{{ url('/departments_app') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Productive Applications</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--begin:Menu item company roles-->

                                        <!--end:Menu item-->

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--begin:Menu item Employees-->
                                <div data-kt-menu-trigger="click"
                                    class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Employees</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('employees') || request()->is('employee/*') ? 'active' : '' }}"
                                                href="{{ url('/employees') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title d-flex align-items-center">
                                                    Employees
                                                    <span class="position-relative">
                                                        <span
                                                            class="bullet bullet-dot bg-success h-6px w-6px animation-blink position-absolute start-50 translate-middle-x"
                                                            style="top: -3px;"></span>
                                                        <span class=""> ({{ $liveEmployeesCount }})</span>
                                                    </span>
                                                </span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="{{ url('/departments_employees') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Productive Applications</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                    </div>
                                </div>
                                @if ($flag == 1)
                                    <!--begin:Menu item Applications-->
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Application Management</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                @php
                                                    $applications_urls = [request()->is('applications'), request()->is('add_new_application'), request()->is('superadmin/applications'), request()->is('superadmin/add_new_application')];
                                                @endphp
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ in_array(Request::url(), $applications_urls) ? 'active' : '' }}"
                                                    href="{{ $flag == 1 ? url('/superadmin/applications') : url('/applications') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Non-Productive Applications</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="{{ url('/applications_categories') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Applications Categories</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                {{-- <div data-kt-menu-trigger="click"
                                    class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Team Management</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('users') || request()->is('user/*') ? 'active' : '' }}"
                                                href="{{ url('/users') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Users</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item company roles-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('roles') ? 'active' : '' }}"
                                                href="{{ url('/roles') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Roles</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--begin:Menu item company roles-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="{{ url('/departments') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Departments</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        @if ($flag == 1)
                                            <!--begin:Menu item company permissions-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link {{ request()->is('permissions') ? 'active' : '' }}"
                                                    href="{{ url('/permissions') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Permissions</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endif
                                    </div>
                                    <!--end:Menu sub-->
                                </div> --}}
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-switch fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i></span>
                                <span class="menu-title">Applications Management</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('categories*') ? 'active' : '' }}"
                                        href="{{ url('/categories') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Categories</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>

                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('master_application') || request()->is('master_application/*') ? 'active' : '' }}"
                                        href="{{ url('/master_application') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Applications</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                    @endif
                    <!--begin:Menu item My Profile-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->is('myprofile') ? 'active' : '' }}"
                            href="{{ url('/myprofile') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-address-book fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">My Profile</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    @php
                        if ($flag != 1) {
                            $request_url_team = [request()->is('users'), request()->is('roles'), request()->is('permissions'), request()->is('user/*')];
                        } else {
                            $request_url_team = [request()->is('superadmin/users'), request()->is('superadmin/roles'), request()->is('superadmin/permissions'), request()->is('user/*')];
                        }

                    @endphp
                    <!--begin:Menu item Team Management-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here' : '' }} menu-accordion {{ in_array(Request::url(), $request_url_team) ? 'hover show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-28 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Team Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div
                            class="menu-sub menu-sub-accordion {{ in_array(Request::url(), $request_url_team) ? 'show' : '' }}">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                @php
                                    $users_urls = [request()->is('users'), request()->is('user/*'), request()->is('superadmin/users'), request()->is('superadmin/user/*')];
                                @endphp
                                <!--begin:Menu link-->
                                <a class="menu-link {{ in_array(Request::url(), $users_urls) ? 'active' : '' }}"
                                    href="{{ $flag == 1 ? url('/superadmin/users') : url('/users') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Users</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                @php
                                    $roles_urls = [request()->is('roles'), request()->is('add_new_role'), request()->is('superadmin/roles'), request()->is('superadmin/add_new_role')];
                                @endphp
                                <!--begin:Menu link-->
                                <a class="menu-link {{ in_array(Request::url(), $roles_urls) ? 'active' : '' }}"
                                    href="{{ $flag == 1 ? url('/superadmin/roles') : url('/roles') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Roles</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                            @if ($flag != 1)
                                <div data-kt-menu-trigger="click"
                                    class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Department Management</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('department') || request()->is('department/*') ? 'active' : '' }}"
                                                href="{{ url('/departments') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Departments</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item company roles-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->is('departments_app') ? 'active' : '' }}"
                                                href="{{ url('/departments_app') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Productive Applications</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--begin:Menu item company roles-->
                                        <!--end:Menu item-->

                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                            @endif

                            {{-- <div class="menu-item">
                                @php
                                    $departments_urls = [request()->is('departments'), request()->is('add_new_department'), request()->is('superadmin/departments'), request()->is('superadmin/add_new_department')];
                                @endphp
                                <!--begin:Menu link-->
                                <a class="menu-link {{ in_array(Request::url(), $departments_urls) ? 'active' : '' }}"
                                    href="{{ $flag == 1 ? url('/superadmin/departments') : url('/departments') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Departments</span>
                                </a>
                                <!--end:Menu link-->
                            </div> --}}
                            <!--end:Menu item-->
                            {{-- <div class="menu-item">
                                @php
                                    $departments_app_urls = [request()->is('departments_app'), request()->is('add_new_department_app'), request()->is('superadmin/departments_app'), request()->is('superadmin/add_new_department_app')];
                                @endphp
                                <!--begin:Menu link-->
                                <a class="menu-link {{ in_array(Request::url(), $departments_app_urls) ? 'active' : '' }}"
                                    href="{{ $flag == 1 ? url('/superadmin/departments_app') : url('/departments_app') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Departments Non-Productive Applications</span>
                                </a>
                                <!--end:Menu link-->
                            </div> --}}
                            <!--end:Menu item-->

                            <!--end:Menu item-->
                            @if ($flag == 1)
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    @php
                                        $permissions_urls = [request()->is('permissions'), request()->is('permission/edit/*'), request()->is('superadmin/permissions'), request()->is('superadmin/permission/edit/*')];
                                    @endphp
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ in_array(Request::url(), $permissions_urls) ? 'active' : '' }}"
                                        href="{{ $flag == 1 ? url('/superadmin/permissions') : url('/permissions') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Permissions</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                    @if ($flag != 1)
                        <div data-kt-menu-trigger="click"
                            class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-user fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Employees</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('employees') || request()->is('employee/*') ? 'active' : '' }}"
                                        href="{{ url('/employees') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title d-flex align-items-center">
                                            Employees
                                            <span class="position-relative">
                                                <span
                                                    class="bullet bullet-dot bg-success h-6px w-6px animation-blink position-absolute start-50 translate-middle-x"
                                                    style="top: -3px;"></span>
                                                <span class=""> ({{ $liveEmployeesCount }})</span>
                                            </span>
                                        </span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{ url('/departments_employees') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Productive Applications</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click"
                            class="menu-item {{ in_array(Request::url(), $request_url_team) ? 'here show' : '' }} menu-accordion mb-1">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-switch fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Applications</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--begin: Application-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->is('applications') || request()->is('application/*') ? 'active' : '' }}"
                                        href="{{ url('/applications') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Applications</span>
                                    </a>
                                    <!--end:Application link-->
                                </div>
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{ url('/applications_categories') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Applications Categories</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            </div>
                        </div>
                        <!--end:Menu item-->
                    @endif
                    <!--begin:Menu item Help section-->
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Help</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item FAQ-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-chart-pie-3 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">FAQ</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item Documentation-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="" target="_blank">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-26 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Documentation</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href=""
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
            title="200+ in-house components and 3rd-party plugins">
            <span class="btn-label">Docs & Components</span>
            <i class="ki-duotone ki-document btn-icon fs-2 m-0">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </a>
    </div>
    <!--end::Footer-->
</div>
<!--end::Sidebar-->
