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
                                        {{ isset($routeName) ? 'Super Admin Permissions' : 'Permissions' }}</h1>
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
                                        <li class="breadcrumb-item text-muted"><a
                                                href="{{ isset($routeName) ? url('/superadmin/permissions') : url('/permissions') }}"
                                                class="text-muted text-hover-primary">Team Management</a></li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted"><a
                                                href="{{ isset($routeName) ? url('/superadmin/permissions') : url('/permissions') }}"
                                                class="text-muted text-hover-primary">Permissions</a></li>
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
                                @if (request()->is('permissions') ||
                                        request()->is('superadmin/permissions') ||
                                        request()->is('permission/*') ||
                                        request()->is('superadmin/permission/*'))
                                    <!--begin::Card-->
                                    <div class="card card-flush">
                                        <!--begin::Card header-->
                                        <div class="card-header mt-6">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <!--begin::Search-->
                                                <div class="d-flex align-items-center position-relative my-1 me-5">
                                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <input type="text" data-kt-permissions-table-filter="search"
                                                        class="form-control form-control-solid w-250px ps-13"
                                                        placeholder="Search Permissions" />
                                                </div>
                                                <!--end::Search-->
                                            </div>
                                            <!--end::Card title-->
                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                <!--begin::Button-->
                                                <button type="button" class="btn btn-light-primary"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                                                    <i class="ki-duotone ki-plus-square fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>Add Permission</button>
                                                <!--end::Button-->
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                                                id="kt_permissions_table">
                                                <thead>
                                                    <tr
                                                        class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="min-w-125px">Name</th>
                                                        <th class="min-w-250px">Assigned to</th>
                                                        <th class="min-w-125px">Created Date</th>
                                                        <th class="text-end min-w-100px">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                    @if (isset($permissions))
                                                        @foreach ($permissions as $val)
                                                            <tr>
                                                                <td>
                                                                    {{ isset($val->title) && isset($val->type) ? $val->type . ' ' . $val->title : '-' }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $bg_types = ['primary', 'success', 'info', 'danger', 'warning'];
                                                                    @endphp
                                                                    @if (isset($val->assign_to))
                                                                        @foreach ($val->assign_to as $k => $v)
                                                                            <a href=""
                                                                                data-id="{{ $k }}"
                                                                                class="edit_role_btn badge badge-light-primary fs-7 m-1 ">{{ $v }}</a>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ isset($val->created_at) ? date('d M Y, h:i a', strtotime($val->created_at)) : '-' }}
                                                                </td>
                                                                <td class="text-end">
                                                                    <a href=""
                                                                        edit_permission_id="{{ $val->id }}"
                                                                        class="edit_permission_btn btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                                        <i class="ki-duotone ki-setting-3 fs-3">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                        </i>
                                                                    </a>
                                                                    <button data-id="{{ $val->id }}"
                                                                        class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                                        data-kt-permissions-table-filter="delete_row">
                                                                        <i class="ki-duotone ki-trash fs-3">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                        </i>
                                                                    </button>
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
                                    <!--begin::Modal - Add permissions-->
                                    <div class="modal fade" id="kt_modal_add_permission" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Add a Permission</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-kt-permissions-modal-action="close">
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
                                                    <form id="kt_modal_add_permission_form" class="form"
                                                        action="" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="modal_id"
                                                            value="#kt_modal_add_permission">
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                                <span class="required">Permission Name</span>
                                                                <span class="ms-2" data-bs-toggle="popover"
                                                                    data-bs-trigger="hover" data-bs-html="true"
                                                                    data-bs-content="Permission names is required to be unique.">
                                                                    <i class="ki-duotone ki-information fs-7">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                    </i>
                                                                </span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input class="form-control form-control-solid"
                                                                placeholder="Enter a permission name" name="title"
                                                                required />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                                <span class="required">Type</span>
                                                                <span class="ms-2" data-bs-toggle="popover"
                                                                    data-bs-trigger="hover" data-bs-html="true"
                                                                    data-bs-content="Permission type unique for permission.">
                                                                    <i class="ki-duotone ki-information fs-7">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                    </i>
                                                                </span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input class="form-control form-control-solid"
                                                                placeholder="Enter a permission type (e.g create, read, update, delete etc.)"
                                                                name="type" required />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Checkbox-->
                                                            <label
                                                                class="form-check form-check-custom form-check-solid me-9">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="1" name="for_superadmin"
                                                                    id="kt_permissions_core" />
                                                                <span class="form-check-label"
                                                                    for="kt_permissions_core">Check if this is only for
                                                                    Super
                                                                    admin</span>
                                                            </label>
                                                            <!--end::Checkbox-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Actions-->
                                                        <div class="text-center pt-15">
                                                            <button type="reset" class="btn btn-light me-3"
                                                                data-kt-permissions-modal-action="cancel">Discard</button>
                                                            <button type="submit" class="btn btn-primary">
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
                                    <!--end::Modal - Add permissions-->
                                    <!--begin::Modal - Update permissions-->
                                    <div class="modal fade" id="kt_modal_update_permission" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Update Permission</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div class="update_permission_close btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-kt-permissions-modal-action="close">
                                                        <i class="ki-duotone ki-cross fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div id="edit_permision_form_div"
                                                    class="modal-body scroll-y mx-5 mx-xl-15 my-7">

                                                </div>
                                                <!--end::Modal body-->
                                            </div>
                                            <!--end::Modal content-->
                                        </div>
                                        <!--end::Modal dialog-->
                                    </div>
                                    <!--end::Modal - Update permissions-->
                                    <!--begin::Modal - Update role-->
                                    <div class="modal fade" id="kt_modal_update_role" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-750px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Update Role</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div class="close_btn btn btn-icon btn-sm btn-active-icon-primary"
                                                        modal_id="kt_modal_update_role"
                                                        data-kt-roles-modal-action="close">
                                                        <i class="ki-duotone ki-cross fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div id="kt_modal_update_role_body"
                                                    class="modal-body scroll-y mx-5 my-7">

                                                </div>
                                                <!--end::Modal body-->
                                            </div>
                                            <!--end::Modal content-->
                                        </div>
                                        <!--end::Modal dialog-->
                                    </div>
                                    <!--end::Modal - Update role-->
                                    <!--end::Modals-->
                                @else
                                    @yield('role_page_content')
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
    <script src="assets/js/custom/apps/user-management/permissions/list.js"></script>
    <script src="assets/js/custom/apps/user-management/permissions/add-permission.js"></script>
    <script src="assets/js/custom/apps/user-management/permissions/update-permission.js"></script>
    @include('components.scripts')
    @yield('script')
    @if (isset($permission))
        <script>
            $(document).ready(function() {
                $('#kt_modal_update_permission').modal('show');

            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(document).on('click', '.update_permission_close', function(e) {
                $('#kt_modal_update_permission').modal('hide');
            });

            $(document).on('click', '.update_permission_discard', function(e) {
                $('#kt_modal_update_permission').modal('hide');
                $('#kt_modal_update_permission_form').reset();
            });
        });
    </script>
</body>
<!--end::Body-->

</html>
