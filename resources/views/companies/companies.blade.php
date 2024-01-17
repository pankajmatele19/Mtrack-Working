<!DOCTYPE html>
<html lang="en">
{{-- head_tag --}}
@include('components.head_tag')
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
                                        Companies</h1>
                                    <!--end::Title-->
                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{ url('/dashboard') }}"
                                                class="text-muted text-hover-primary">Home</a>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted"><a href="{{ url('/companies') }}"
                                                class="text-muted text-hover-primary">Companies</a></li>
                                        <!--end::Item-->
                                        @yield('breadcrumb')
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    @yield('action_btns_toolbar')
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
                                @if (request()->is('companies'))
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
                                                                    class="form-label fs-5 fw-semibold mb-3">Month:</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select class="form-select form-select-solid fw-bold"
                                                                    data-kt-select2="true"
                                                                    data-placeholder="Select option"
                                                                    data-allow-clear="true"
                                                                    data-kt-datatable-table-filter="month"
                                                                    data-dropdown-parent="#kt-toolbar-filter">
                                                                    <option></option>
                                                                    <option value="01-">January</option>
                                                                    <option value="02-">February</option>
                                                                    <option value="03-">March</option>
                                                                    <option value="04-">April</option>
                                                                    <option value="05-">May</option>
                                                                    <option value="06-">June</option>
                                                                    <option value="07-">July</option>
                                                                    <option value="08-">August</option>
                                                                    <option value="09-">September</option>
                                                                    <option value="10-">October</option>
                                                                    <option value="11-">November</option>
                                                                    <option value="12-">December</option>
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
                                                    <!--begin::Export-->
                                                    <button type="button" class="btn btn-light-primary me-3"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_datatable_export_modal">
                                                        <i class="ki-duotone ki-exit-up fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>Export</button>
                                                    <!--end::Export-->
                                                    <!--begin::Add Company-->
                                                    {{-- <a href="{{ url('/company/add_new') }}" class="btn btn-primary"><i
                                                            class="ki-duotone ki-plus fs-2"></i>Add Company</a> --}}
                                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#addCompanyModal" id="openAddCompanyModal">
                                                        <i class="ki-duotone ki-plus fs-2"></i>Add Company
                                                    </a>
                                                    <!--end::Add Company-->
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
                                                        <th class="min-w-125px">Name</th>
                                                        <th class="min-w-125px">Website</th>
                                                        <th class="min-w-125px">Total Employees</th>
                                                        {{-- <th class="min-w-125px">Contact Name</th> --}}
                                                        <th class="min-w-125px">Contact Email</th>
                                                        <th class="min-w-125px">Joined Date</th>
                                                        <th class="text-center min-w-70px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                    @if (isset($companies))
                                                        @foreach ($companies as $key => $val)
                                                            <tr>
                                                                <td>
                                                                    <div
                                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                                        <input class="form-check-input"
                                                                            type="checkbox"
                                                                            value="{{ isset($val->id) ? $val->id : '-' }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ $val->id }}"
                                                                        class="view_company text-gray-800 text-hover-primary mb-1">{{ isset($val->company_name) ? $val->company_name : '-' }}</a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ $val->id }}"
                                                                        class="view_company text-gray-600 text-hover-primary mb-1">{{ isset($val->company_website) ? $val->company_website : '-' }}</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="{{ $val->id }}"
                                                                        class="view_company text-gray-600 text-hover-primary mb-1">{{ isset($val->employees_count) ? $val->employees_count : '-' }}</a>
                                                                </td>
                                                                {{-- <td>
                                                                        <a href="{{$val->id}}" class="view_company text-gray-600 text-hover-primary mb-1">{{(isset($val->contact_name)) ? $val->contact_name : '-'}}</a>
                                                                    </td> --}}
                                                                <td>
                                                                    <a href="{{ $val->id }}"
                                                                        class="view_company text-gray-600 text-hover-primary mb-1">{{ isset($val->contact_email) ? $val->contact_email : '-' }}</a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ $val->id }}"
                                                                        class="view_company text-gray-600 text-hover-primary mb-1">{{ isset($val->created_at) ? $val->created_at : '-' }}</a>
                                                                </td>
                                                                <td class="text-end">
                                                                    <a class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                                        data-kt-menu-trigger="click"
                                                                        data-kt-menu-placement="bottom-end">Actions
                                                                        <i
                                                                            class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                                    <!--begin::Menu-->
                                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                                        data-kt-menu="true">
                                                                        <!--begin::Menu item users-->
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ url('/users') . '/' . (isset($val->id) ? $val->id : '') }}"
                                                                                class="menu-link px-3">Users</a>
                                                                        </div>
                                                                        <!--end::Menu item-->
                                                                        <!--begin::Menu item roles-->
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ url('/roles') . '/' . (isset($val->id) ? $val->id : '') }}"
                                                                                class="menu-link px-3">Roles</a>
                                                                        </div>
                                                                        <!--end::Menu item-->
                                                                        <!--begin::Menu item employees-->
                                                                        <div class="menu-item px-3">
                                                                            <a href="{{ url('/employees') . '/' . (isset($val->id) ? $val->id : '') }}"
                                                                                class="menu-link px-3">Employees</a>
                                                                        </div>
                                                                        <!--end::Menu item-->
                                                                        <!--begin::Menu item edit company-->
                                                                        <div class="menu-item px-3">
                                                                            <a href=""
                                                                                class="menu-link px-3 edit_company"
                                                                                data-toggle="modal"
                                                                                data-target="#editCompanyModal"
                                                                                data-company-id="{{ isset($val->id) ? $val->id : '' }}">
                                                                                Edit
                                                                            </a>
                                                                            {{-- <a href="{{ url('/company/edit') . '/' . (isset($val->id) ? $val->id : '') }}"
                                                                                class="menu-link px-3">Edit</a> --}}
                                                                        </div>
                                                                        <!--end::Menu item-->
                                                                        <!--begin::Menu item delete company-->
                                                                        <div class="menu-item px-3">
                                                                            <a href=""
                                                                                data-id="{{ $val->id }}"
                                                                                class="delete menu-link px-3"
                                                                                data-kt-datatable-table-filter="delete_row">Delete</a>
                                                                        </div>
                                                                        <!--end::Menu item-->
                                                                    </div>
                                                                    <!--end::Menu-->
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Modals-->
                                    <!-- Add this HTML code for the modal -->
                                    <div class="modal fade" id="addCompanyModal" tabindex="-1"
                                        aria-labelledby="addCompanyModalLabel" aria-hidden="true">
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
                                    <div class="modal fade" id="editCompanyModal" tabindex="-1"
                                        aria-labelledby="editCompanyModalLabel" aria-hidden="true">
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
                                    <!--begin::Modal - Companies - Add-->
                                    <div class="modal fade" id="kt_modal_view_company" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header" id="kt_modal_view_company_header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Company Details</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div id="kt_modal_close_view_company"
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
                                                <div class="modal-body" id="kt_modal_view_company_scroll">

                                                </div>
                                                <!--end::Modal body-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal - Companies - Add-->
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
                                                    <h2 class="fw-bold">Export Companies</h2>
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
                                    @yield('company_page_content')
                                @endif
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->

                    @include('components.footer')

                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    @include('components.scripts')
    @yield('script')
    <script>
        document.getElementById('openAddCompanyModal').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#addCompanyModal').modal('show'); // Open the modal using Bootstrap modal method
            // Fetch the add/edit company form via Ajax
            $.ajax({
                url: "{{ url('/company/add_new') }}",
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    // Set the modal content with the fetched data
                    $('#addCompanyModal .modal-body').html(data);
                    // Open the modal using Bootstrap modal method
                    $('#addCompanyModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.edit_company', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#editCompanyModal').modal('show'); // Open the modal using Bootstrap modal method
            // Fetch the add/edit company form via Ajax
            var comp_id = this.getAttribute('data-company-id');
            $.ajax({
                url: "{{ url('/company/edit') }}/" + comp_id,
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    // Set the modal content with the fetched data
                    $('#editCompanyModal .modal-body').html(data);
                    // Open the modal using Bootstrap modal method
                    $('#editCompanyModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>

</body>
<!--end::Body-->

</html>
