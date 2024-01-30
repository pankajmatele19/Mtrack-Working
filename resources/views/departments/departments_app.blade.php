<!DOCTYPE html>
<html lang="en">
{{-- head_tag --}}
@include('components.head_tag')
<style>
    .status-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        display: inline-block;
        margin-left: 2px;
        /* Adjust the left margin as needed */
        vertical-align: top;
        /* Align vertically to the middle of the line */
        animation: blink-animation 1s infinite;
        /* Adjust the animation duration as needed */
    }

    .active {
        background-color: green;
    }

    .inactive {
        background-color: red;
    }

    @keyframes blink-animation {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            @include('components.header')

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                @include('components.sidebar')
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                                <!--begin::Page title-->
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <!--begin::Title-->
                                    <h1
                                        class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        {{ isset($routeName) ? 'Super Admin Departments' : 'Departments Application' }}
                                    </h1>
                                    <!--end::Title-->
                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{ url('/dashboard') }}"
                                                class="text-muted text-hover-primary">Home</a>
                                        </li>
                                        <!--end::Item-->
                                        @if (request()->is('roles/*') && isset($prev_page_id))
                                            <!--begin::Item-->
                                            <li class="breadcrumb-item">
                                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                            </li>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-muted"><a href="{{ url('/departments') }}"
                                                    class="text-muted text-hover-primary">Departments</a></li>
                                            <!--end::Item-->
                                        @endif
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted"><a
                                                href="{{ isset($routeName) ? url('superadmin/roles') : url('/roles') . (isset($prev_page_id) ? '/' . $prev_page_id : '') }}"
                                                class="text-muted text-hover-primary">Deparments Application</a></li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        {{-- <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li> --}}
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        {{-- <li class="breadcrumb-item text-muted"><a
                                                href="{{ isset($routeName) ? url('superadmin/departments') : url('/departments') . (isset($prev_page_id) ? '/' . $prev_page_id : '') }}"
                                                class="text-muted text-hover-primary">Departments Application</a></li> --}}
                                        <!--end::Item-->
                                        @yield('breadcrumb')
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    @yield('action_btns_toolbar')
                                    @if (request()->is('roles/*') && isset($prev_page_id))
                                        <a href="{{ url('users') . '/' . $prev_page_id }}"
                                            class="btn btn-sm fw-bold btn-light-primary">Users</a>
                                        <a href="{{ url('/companies') }}"
                                            class="btn btn-sm fw-bold btn-primary">Back</a>
                                    @endif
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-xxl">
                                @if (request()->is('departments_app') ||
                                        request()->is('superadmin/departments_app') ||
                                        request()->is('departments_app/*'))
                                    <!--begin::Card-->
                                    <div class="card">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 pt-6">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <!--begin::Search-->
                                                <div class="d-flex align-items-center position-relative my-1">
                                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <input type="text" data-kt-datatable-table-filter="search"
                                                        class="form-control form-control-solid w-250px ps-12"
                                                        placeholder="Search..." />
                                                </div>
                                                <!--end::Search-->
                                            </div>
                                            <!--begin::Card title-->
                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                <!--begin::Toolbar-->
                                                <div class="d-flex justify-content-end"
                                                    data-kt-datatable-table-toolbar="base">
                                                    <!--begin::Filter-->
                                                    @if ($flag == 1)
                                                        <button type="button" class="btn btn-light-primary me-3"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end">
                                                            <i class="ki-duotone ki-filter fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>Filter</button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                            data-kt-menu="true" id="kt-toolbar-filter">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-4 text-dark fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Separator-->
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label
                                                                        class="form-label fs-5 fw-semibold mb-3">Companies:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select
                                                                        class="form-select form-select-solid fw-bold"
                                                                        data-kt-select2="true"
                                                                        data-placeholder="Select option"
                                                                        data-allow-clear="true"
                                                                        data-kt-datatable-table-filter="month"
                                                                        data-dropdown-parent="#kt-toolbar-filter">
                                                                        <option></option>
                                                                        <option value="01-">Metricoid</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-active-light-primary me-2"
                                                                        data-kt-menu-dismiss="true"
                                                                        data-kt-datatable-table-filter="reset">Reset</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-kt-menu-dismiss="true"
                                                                        data-kt-datatable-table-filter="filter">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Filter-->
                                                    @endif
                                                    <!--begin::Export-->
                                                    <button type="button" class="btn btn-light-primary me-3"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_datatable_export_modal">
                                                        <i class="ki-duotone ki-exit-up fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>Export</button>
                                                    <!--end::Export-->
                                                    <!--begin::Add User-->
                                                    {{-- <a href="{{ isset($routeName) ? url('/superadmin/department/add') : url('/department/add') }}"
                                                        class="btn btn-primary"><i
                                                            class="ki-duotone ki-plus fs-2"></i>Add departments App</a> --}}
                                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#addDepartmentsAppModal"
                                                        id="openAddDepartmentsAppModal">
                                                        <i class="ki-duotone ki-plus fs-2"></i>Add Departments App
                                                    </a>
                                                    <!--end::Add User-->
                                                </div>
                                                <!--end::Toolbar-->
                                                <!--begin::Group actions-->
                                                <div class="d-flex justify-content-end align-items-center d-none"
                                                    data-kt-datatable-table-toolbar="selected">
                                                    <div class="fw-bold me-5">
                                                        <span class="me-2"
                                                            data-kt-datatable-table-select="selected_count"></span>Selected
                                                    </div>
                                                    <button type="button" class="btn btn-danger"
                                                        data-kt-datatable-table-select="delete_selected">Delete
                                                        Selected</button>
                                                </div>
                                                <!--end::Group actions-->
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                id="kt_datatable_table">
                                                <thead>
                                                    <tr
                                                        class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="w-10px pe-2">
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    data-kt-check="true"
                                                                    data-kt-check-target="#kt_datatable_table .form-check-input"
                                                                    value="" />
                                                            </div>
                                                        </th>
                                                        <th class="min-w-125px">Department Name</th>
                                                        <th class="min-w-125px">Application Name</th>
                                                        <th class="min-w-125px">Category Name</th>
                                                        {{-- <th class="min-w-125px">Is Non-Productive</th> --}}
                                                        {{-- <th class="min-w-125px">Status</th> --}}
                                                        @if ($flag == 1)
                                                            <th class="min-w-125px">Company</th>
                                                        @endif
                                                        <th class="text-center min-w-70px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                    {{-- @if (isset($departments_app)) --}}
                                                    @foreach ($departmentNonProductiveApps->where('status', 1) as $val)
                                                        <tr data-id="{{ $val->id }}">
                                                            <td>
                                                                <div
                                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="{{ $val->id }}" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="menu-title d-flex align-items-center">
                                                                    {{ isset($val->department_name) ? $val->department_name : '-' }}
                                                                    {{-- <span class="position-relative">
                                                                        <span
                                                                            class="status-dot @if ($val->status == 1) active @else inactive @endif"></span>
                                                                    </span> --}}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ $val->id }}"
                                                                    class="view_user text-gray-800 text-hover-primary mb-1">{{ isset($val->app_name) ? $val->app_name : '-' }}</a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ $val->id }}"
                                                                    class="view_user text-gray-800 text-hover-primary mb-1">{{ isset($val->category_name) ? $val->category_name : '-' }}</a>
                                                            </td>
                                                            {{-- <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input toggle-switch"
                                                                        type="checkbox"
                                                                        id="toggleSwitch{{ $val->id }}"
                                                                        data-application-id="{{ $val->id }}"
                                                                        @if ($val->status == 1) checked @endif>
                                                                </div>
                                                            </td> --}}
                                                            {{-- <td>
                                                                <div class="">
                                                                    <span class=""
                                                                        data-application-id="{{ $val->id }}"
                                                                        data-status="{{ $val->status }}">
                                                                        @if ($val->status == 1)
                                                                            Active
                                                                        @else
                                                                            Inactive
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </td> --}}
                                                            @if ($flag == 1)
                                                                <td>
                                                                    <a href="{{ $val->id }}"
                                                                        class="view_user text-gray-600 text-hover-primary mb-1">{{ isset($val->company_name) ? $val->company_name : '-' }}</a>
                                                                </td>
                                                            @endif
                                                            <td class="text-end">
                                                                <a class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                                    data-kt-menu-trigger="click"
                                                                    data-kt-menu-placement="bottom-end">Actions
                                                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                                <!--begin::Menu-->
                                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                                    data-kt-menu="true">
                                                                    <!--begin::Menu item-->
                                                                    {{-- <div class="menu-item px-3">
                                                                        <a href=""
                                                                            class="menu-link px-3 edit_departmentsApp"
                                                                            data-toggle="modal"
                                                                            data-target="#editDepartmentsAppModal"
                                                                            data-departments-app-id="{{ isset($val->id) ? $val->id : '' }}">
                                                                            Edit
                                                                        </a>
                                                                    </div> --}}
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="javascript:void(0);"
                                                                            data-id="{{ $val->id }}"
                                                                            class="delete menu-link px-3"
                                                                            data-kt-datatable-table-filter="delete_row"
                                                                            onclick="softDeleteDepartmentApp({{ $val->id }})">Remove</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                </div>
                                                                <!--end::Menu-->
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    {{-- @endif --}}
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Modals-->
                                    <!-- Add this HTML code for the modal -->
                                    <div class="modal fade" id="addDepartmentsAppModal" tabindex="-1"
                                        aria-labelledby="addDepartmentsAppModalLabel" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!-- Add close button -->
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Add your form or content for adding a new company here -->
                                                    <!-- Example: <form id="addCompanyForm"> ... </form> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add this HTML code for the modal -->
                                    <div class="modal fade" id="editDpartmentsAppModal" tabindex="-1"
                                        aria-labelledby="editDpartmentsAppModalLabel" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!-- Your modal content goes here -->
                                                <div class="modal-header">
                                                    <!-- Add close button -->
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Add your form or content for adding a new company here -->
                                                    <!-- Example: <form id="addCompanyForm"> ... </form> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Modal - Users - Add-->
                                    <div class="modal fade" id="kt_modal_departments_app" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header" id="kt_modal_departments_app_header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Company Details</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div id="kt_modal_close_departments_app"
                                                        class="btn btn-icon btn-sm btn-active-icon-primary">
                                                        <i class="ki-duotone ki-cross fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div class="modal-body" id="kt_modal_departments_app_scroll">

                                                </div>
                                                <!--end::Modal body-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal - Users - Add-->
                                    <!--begin::Modal - Adjust Balance-->
                                    <div class="modal fade" id="kt_datatable_export_modal" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Export Users</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div id="kt_datatables_export_close"
                                                        class="btn btn-icon btn-sm btn-active-icon-primary">
                                                        <i class="ki-duotone ki-cross fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <!--begin::Form-->
                                                    <form id="kt_datatable_export_form" class="form"
                                                        action="#">
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="fs-5 fw-semibold form-label mb-5">Select
                                                                Export Format:</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select data-control="select2"
                                                                data-placeholder="Select a format"
                                                                data-hide-search="true" name="format"
                                                                class="form-select form-select-solid">
                                                                <option value="excell">Excel</option>
                                                                <option value="pdf">PDF</option>
                                                                <option value="cvs">CVS</option>
                                                                <option value="zip">ZIP</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="fs-5 fw-semibold form-label mb-5">Select Date
                                                                Range:</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input class="form-control form-control-solid"
                                                                placeholder="Pick a date" name="date" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Actions-->
                                                        <div class="text-center">
                                                            <button type="reset" id="kt_datatable_export_cancel"
                                                                class="btn btn-light me-3">Discard</button>
                                                            <button type="submit" id="kt_datatable_export_submit"
                                                                class="btn btn-primary">
                                                                <span class="indicator-label">Submit</span>
                                                                <span class="indicator-progress">Please wait...
                                                                    <span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                        </div>
                                                        <!--end::Actions-->
                                                    </form>
                                                    <!--end::Form-->
                                                </div>
                                                <!--end::Modal body-->
                                            </div>
                                            <!--end::Modal content-->
                                        </div>
                                        <!--end::Modal dialog-->
                                    </div>
                                    <!--end::Modal - New Card-->
                                    <!--end::Modals-->
                                @else
                                    @yield('department_page_content')
                                @endif
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                        @include('components.footer')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.scripts')
    <script>
        document.getElementById('openAddDepartmentsAppModal').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#addDepartmentsAppModal').modal('show'); // Open the modal using Bootstrap modal method
            // Fetch the add/edit company form via Ajax
            $.ajax({
                url: "{{ url('/departments_app/add') }}",
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    // Set the modal content with the fetched data
                    $('#addDepartmentsAppModal .modal-body').html(data);
                    // Open the modal using Bootstrap modal method
                    $('#addDepartmentsAppModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', xhr.responseText);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.edit_departmentsApp', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#editDpartmentsAppModal').modal('show'); // Open the modal using Bootstrap modal method
            // Fetch the add/edit company form via Ajax
            var dept_id = this.getAttribute('data-departments-app-id');
            $.ajax({
                url: "{{ url('/departments_app/edit/') }}/" + dept_id,
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    // Set the modal content with the fetched data
                    $('#editDpartmentsAppModal .modal-body').html(data);
                    // Open the modal using Bootstrap modal method
                    $('#editDpartmentsAppModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.toggle-switch', function() {
                var applicationId = $(this).data('application-id');
                var status = this.checked ? 1 : 0;
                console.log(applicationId);
                // Get the CSRF token from the meta tag in your HTML
                // var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Send an AJAX request to update the status
                $.ajax({
                    type: 'POST',
                    url: '/departments-applications/update-application-status',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "application_id": applicationId,
                        "status": status
                    },
                    success: function(data) {
                        // Update the view to hide the row if status is 0
                        if (status === 0) {
                            $('#applicationRow' + applicationId).remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <script>
        function softDeleteDepartmentApp(applicationId) {
            $.ajax({
                type: 'POST',
                url: '/departments-applications/soft-delete-employee-app',
                data: {
                    _token: '{{ csrf_token() }}',
                    application_id: applicationId
                },
                success: function(response) {
                    // Handle success, maybe reload the table or update UI
                    console.log(response.message);
                    $('#kt_datatable_table').find('tr[data-id="' + applicationId + '"]').remove();
                },
                error: function(error) {
                    // Handle error
                    console.error('Error deleting record:', error);
                }
            });
        }
    </script>
</body>
