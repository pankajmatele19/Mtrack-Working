<!DOCTYPE html>
<html lang="en">
{{-- head_tag --}}
<!--begin::Head-->

<head>
    <base href="{{ url('/') }}" />
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8" />

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <link rel="canonical" href="{{ url('/') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/shorticon.png') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script src="https://unpkg.com/peerjs@1.3.2/dist/peerjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"
        integrity="sha512-zoJXRvW2gC8Z0Xo3lBbao5+AS3g6YWr5ztKqaicua11xHo+AvE1b0lT9ODgrHTmNUxeCw0Ry4BGRYZfXu70weg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script> --}}

    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        /*  datatables css  */
        #export-button {}

        .dt-btn {
            display: none !important;
            color: #03045e !important;
            background-color: #f1faff !important;
            border: 0 !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 1.1rem !important;
            padding: calc(0.75rem + 1px) calc(1.5rem + 1px) !important;
        }

        .dt-buttons .btn {
            /* margin-top: 0.5rem !important; */
            display: none !important;
        }

        .dataTables_info {
            display: none !important;
            margin-right: 10px;
        }

        /* .dataTables_length {
        margin-left: 0px;
    }

    @media (min-width: 768px) {
        .dataTables_length {
            margin-left: 170px !important;
        }
    } */
        #applications_table_filter {
            display: none !important;
        }

        /* end */
        #kt_app_main.loading::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-container {
            display: none;
        }

        #kt_app_main.loading .loader-container {
            display: flex;
        }

        .loading-spinner {
            border: 5px solid rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            border-top: 5px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        #loader.show {
            display: flex;
        }

        body.loading {
            overflow: hidden;
            /* Prevent scrolling when loader is shown */
        }

        body.loading::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Adjust the opacity as needed */
            z-index: 9998;
        }
    </style>


</head>
<!--end::Head-->
<!-- Include jQuery -->
<!-- Include Bootstrap datepicker script -->
{{-- <script src="path/to/bootstrap-datepicker.min.js"></script> --}}

<!--begin::Body-->
<meta name="csrf-token" content="{{ csrf_token() }}">

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
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
                                        {{ isset($routeName) ? 'Super Admin Applications' : 'Applications' }}
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
                                        @if (request()->is('applications/*') && isset($prev_page_id))
                                            <!--begin::Item-->
                                            <li class="breadcrumb-item">
                                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                            </li>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-muted"><a href="{{ url('/companies') }}"
                                                    class="text-muted text-hover-primary">Company</a></li>
                                            <!--end::Item-->
                                        @endif
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted"><a
                                                href="{{ isset($routeName) ? url('superadmin/applications') : url('/applications') . (isset($prev_page_id) ? '/' . $prev_page_id : '') }}"
                                                class="text-muted text-hover-primary">Applications</li>
                                        <!--end::Item-->
                                        @yield('breadcrumb')
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    @yield('action_btns_toolbar')
                                    @if (request()->is('applications/*') && isset($prev_page_id))
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
                                @if (request()->is('applications') || request()->is('superadmin/applications') || request()->is('applications/*'))
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
                                                    <input type="text" id="search"
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
                                                    <button type="button" id="application-filter-button"
                                                        class="btn btn-light-primary me-3"
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
                                                                    class="form-label fs-5 fw-semibold mb-3">Categories:</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select class="form-select form-select-solid fw-bold"
                                                                    data-kt-select2="true"
                                                                    data-placeholder="Select option"
                                                                    data-allow-clear="true"
                                                                    data-kt-datatable-table-filter="month"
                                                                    data-dropdown-parent="#kt-toolbar-filter">
                                                                    <option></option>
                                                                    <option value="01-">entertainment</option>
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
                                                    <button type="button" id="export-button"
                                                        class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                                        data-bs-target="#kt_datatable_export_modal">
                                                        <i class="ki-duotone ki-exit-up fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>Export</button>
                                                    <!--end::Export-->
                                                    <!--begin::Add User-->
                                                    {{-- <a href="{{ isset($routeName) ? url('/superadmin/application/add') : url('/application/add') }}"
                                                        class="btn btn-primary"><i
                                                            class="ki-duotone ki-plus fs-2"></i>Add applications</a> --}}
                                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#addApplicationModal"
                                                        id="openAddApplicationModal">
                                                        <i class="ki-duotone ki-plus fs-2"></i>Add Application
                                                    </a>
                                                    <!--end::Add User-->
                                                </div>
                                                <!--end::Toolbar-->
                                                <!--begin::Group actions-->
                                                <!--end::Group actions-->
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                id="applications_table">
                                                <thead>
                                                    <tr
                                                        class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="w-10px pe-2">
                                                            Is Non-Productive
                                                        </th>
                                                        <th class="min-w-125px">App Name</th>
                                                        <th class="min-w-125px">Description</th>
                                                        {{-- @if ($flag == 1) --}}
                                                        <th class="min-w-125px">Company</th>
                                                        {{-- @endif --}}
                                                        <th class="min-w-125px">Category</th>
                                                        <th class="text-center min-w-70px">Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Modals-->
                                    <!-- Add this HTML code for the modal -->
                                    <div class="modal fade" id="addApplicationModal" tabindex="-1"
                                        aria-labelledby="addApplicationModalLabel" aria-hidden="true">
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
                                    <div class="modal fade" id="editApplicationModal" tabindex="-1"
                                        aria-labelledby="editApplicationModalLabel" aria-hidden="true">
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
                                    <div class="modal fade" id="kt_modal_view_user" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header" id="kt_modal_view_user_header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Application Details</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div id="kt_modal_close_view_user"
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
                                                <div class="modal-body" id="kt_modal_view_user_scroll">

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
                                    @yield('application_page_content')
                                @endif
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    @include('components.footer')

                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    <script>
        var hostUrl = "{{ asset('assets/') }}";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
    {{-- @include('components.scripts') --}}
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!--Begin DATATABLE JS-->
    {{-- start: datatable script --}}
    {{-- <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('/assets/js/custom_datatable.js') }}"></script>
    {{-- end: datatable script --}}
    <!--End DATATABLE JS-->
    @yield('script')
    <script>
        $(document).ready(function() {


            ajax_route_applications_table = {
                url: "",
                data: function(data) {
                    data.customParam = 'applications_table'; // Add your extra parameter(s) here
                },
                error: function(response) {
                    if (response.status == 401) {
                        window.location.href = "{{ url('/') }}"
                    }
                }
            };

            table_columns_applications_table = [{
                    data: 'is_nonproductive',
                    name: 'is_nonproductive',
                    width: '25%'
                },
                {
                    data: 'app_name',
                    name: 'app_name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                    @if ($flag != 1)
                        , visible: false
                    @endif
                },
                {
                    data: 'category_name',
                    name: 'category_name',
                    width: '10%'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ];

            var action_after_callback_function = function(oSettings) {
                $('[data-bs-toggle="tooltip"]').tooltip();

            }

            var table = datatableWithAjax("applications_table", ajax_route_applications_table,
                table_columns_applications_table, "export-button", "search", action_after_callback_function);
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.toggle-switch', function() {
                var applicationId = $(this).data('application-id');
                var status = this.checked ? 1 : 0;
                console.log(status);
                // Get the CSRF token from the meta tag in your HTML
                // var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Send an AJAX request to update the status
                $.ajax({
                    type: 'POST',
                    url: '/applications/update-application-status',
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
        document.getElementById('openAddApplicationModal').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#addApplicationModal').modal('show'); // Open the modal using Bootstrap modal method
            // Fetch the add/edit company form via Ajax
            $.ajax({
                url: "{{ url('/application/add') }}",
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    // Set the modal content with the fetched data
                    $('#addApplicationModal .modal-body').html(data);
                    // Open the modal using Bootstrap modal method
                    $('#addApplicationModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.edit_application', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag
            $('#editApplicationModal').modal('show'); // Open the modal using Bootstrap modal method
            // Fetch the add/edit company form via Ajax
            var app_id = this.getAttribute('data-application-id');
            $.ajax({
                url: "{{ url('/application/edit') }}/" + app_id,
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    // Set the modal content with the fetched data
                    $('#editApplicationModal .modal-body').html(data);
                    // Open the modal using Bootstrap modal method
                    $('#editApplicationModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>
    <script>
        function softDeleteCompanyApp(applicationId) {
            $.ajax({
                type: 'POST',
                url: '/company-applications/soft-delete-company-app',
                data: {
                    _token: '{{ csrf_token() }}',
                    application_id: applicationId
                },
                success: function(response) {
                    // Handle success, maybe reload the table or update UI
                    console.log(response.message);
                    $('#applications_table').find('tr[data-id="' + applicationId + '"]').remove();
                    location.reload();
                },
                error: function(error) {
                    // Handle error
                    console.error('Error deleting record:', error);
                }
            });
        }
    </script>
</body>
<!--end::Body-->

</html>
