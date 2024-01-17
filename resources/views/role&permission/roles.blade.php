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
                                        {{ isset($routeName) ? 'Super Admin Roles' : 'Roles' }}</h1>
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
                                                href="{{ isset($routeName) ? url('superadmin/roles') : url('/roles') . (isset($prev_page_id) ? '/' . $prev_page_id : '') }}"
                                                class="text-muted text-hover-primary">Team Management</a></li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted"><a
                                                href="{{ isset($routeName) ? url('superadmin/roles') : url('/roles') . (isset($prev_page_id) ? '/' . $prev_page_id : '') }}"
                                                class="text-muted text-hover-primary">Roles</a></li>
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
                                @if (request()->is('roles') || request()->is('superadmin/roles') || request()->is('roles/*'))
                                    <!--begin::Content-->
                                    <div id="kt_app_content" class="app-content flex-column-fluid">
                                        <!--begin::Content container-->
                                        <div id="kt_app_content_container" class="app-container container-xxl">
                                            <!--begin::Row-->
                                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                                                @if (isset($roles))
                                                    @foreach ($roles as $key => $val)
                                                        <!--begin::Col-->
                                                        <div class="col-md-4">
                                                            <!--begin::Card-->
                                                            <div class="card card-flush h-md-100">
                                                                <!--begin::Card header-->
                                                                <div class="card-header row">
                                                                    <!--begin::Card title-->
                                                                    <div class="card-title col-md-12">
                                                                        <h2>{{ isset($val->title) ? $val->title : 'unknown' }}
                                                                        </h2>
                                                                    </div>
                                                                    <!--end::Card title-->
                                                                    <div class="col-md-12">
                                                                        <span>{{ $val->company_name }}</span>
                                                                    </div>
                                                                </div>
                                                                <!--end::Card header-->
                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-1">
                                                                    <!--begin::Users-->
                                                                    <div class="fw-bold text-gray-600 mb-5">Total users
                                                                        with this role:
                                                                        {{ isset($total_users) ? $total_users : '' }}
                                                                    </div>
                                                                    <!--end::Users-->
                                                                    <!--begin::Permissions-->
                                                                    <div class="d-flex flex-column text-gray-600">
                                                                        @foreach ($val->permissions as $title => $permission)
                                                                            <div class="d-flex align-items-center py-2">
                                                                                <span
                                                                                    class="bullet bg-primary me-3"></span>
                                                                                {{ $title }}
                                                                            </div>
                                                                        @endforeach
                                                                        @if (count($val->permissions) > 5)
                                                                            <div class="d-flex align-items-center py-2">
                                                                                <span
                                                                                    class='bullet bg-primary me-3'></span>
                                                                                <em>and
                                                                                    {{ $val->permissions->count() - 5 }}
                                                                                    more...</em>
                                                                            </div>
                                                                        @endif
                                                                        @if (count($val->permissions) === 0)
                                                                            <div class="d-flex align-items-center py-2">
                                                                                <span
                                                                                    class='bullet bg-primary me-3'></span>
                                                                                <em>No permissions given...</em>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <!--end::Permissions-->
                                                                </div>
                                                                <!--end::Card body-->
                                                                <!--begin::Card footer-->
                                                                <div class="card-footer flex-wrap pt-0 text-end">
                                                                    {{-- <a href="" class="btn btn-light btn-active-primary my-1 me-2">View Role</a> --}}
                                                                    <button type="button"
                                                                        data-id="{{ $val->id }}"
                                                                        class="edit_role_btn btn btn-light btn-active-light-primary my-1">Edit
                                                                        Role</button>
                                                                </div>
                                                                <!--end::Card footer-->
                                                            </div>
                                                            <!--end::Card-->
                                                        </div>
                                                        <!--end::Col-->
                                                    @endforeach
                                                @endif

                                                <!--begin::Add new card-->
                                                <div class="col-md-4">
                                                    <!--begin::Card-->
                                                    <div class="card h-md-100">
                                                        <!--begin::Card body-->
                                                        <div class="card-body d-flex flex-center">
                                                            <!--begin::Button-->
                                                            <button type="button"
                                                                class="btn btn-clear d-flex flex-column flex-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_add_role">
                                                                <!--begin::Illustration-->
                                                                <img src="assets/media/illustrations/sketchy-1/4.png"
                                                                    alt="" class="mw-100 mh-150px mb-7" />
                                                                <!--end::Illustration-->
                                                                <!--begin::Label-->
                                                                <div
                                                                    class="fw-bold fs-3 text-gray-600 text-hover-primary">
                                                                    Add New Role</div>
                                                                <!--end::Label-->
                                                            </button>
                                                            <!--begin::Button-->
                                                        </div>
                                                        <!--begin::Card body-->
                                                    </div>
                                                    <!--begin::Card-->
                                                </div>
                                                <!--begin::Add new card-->
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Modals-->
                                            <!--begin::Modal - Add role-->
                                            <div class="modal fade" id="kt_modal_add_role" tabindex="-1"
                                                aria-hidden="true">
                                                <!--begin::Modal dialog-->
                                                <div class="modal-dialog modal-dialog-centered mw-750px">
                                                    <!--begin::Modal content-->
                                                    <div class="modal-content">
                                                        <!--begin::Modal header-->
                                                        <div class="modal-header">
                                                            <!--begin::Modal title-->
                                                            <h2 class="fw-bold">Add a Role</h2>
                                                            <!--end::Modal title-->
                                                            <!--begin::Close-->
                                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
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
                                                        <div class="modal-body scroll-y mx-lg-5 my-7">
                                                            <!--begin::Form-->
                                                            <form id="kt_modal_add_role_form" class="form"
                                                                action="{{ isset($routeName) ? url('/superadmin/add_new_role') : url('/add_new_role') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="modal_id"
                                                                    value="#kt_modal_add_role">
                                                                <!--begin::Scroll-->
                                                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                                    id="kt_modal_add_role_scroll"
                                                                    data-kt-scroll="true"
                                                                    data-kt-scroll-activate="{default: false, lg: true}"
                                                                    data-kt-scroll-max-height="auto"
                                                                    data-kt-scroll-dependencies="#kt_modal_add_role_header"
                                                                    data-kt-scroll-wrappers="#kt_modal_add_role_scroll"
                                                                    data-kt-scroll-offset="300px">
                                                                    @if ($flag == 1 && !isset($routeName))
                                                                        <div class="col-md-6 mb-8">
                                                                            <!--begin::Label-->
                                                                            <label
                                                                                class="fs-5 fw-bold form-label mb-2">
                                                                                <span class="required">Company</span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <select id="company" name="company_id"
                                                                                aria-label="Select Company"
                                                                                data-control="select2"
                                                                                data-placeholder="Select Company..."
                                                                                data-dropdown-parent="#kt_modal_add_role"
                                                                                class="form-select form-select-solid fw-bold"
                                                                                required>
                                                                                <option value="">Select Company
                                                                                </option>
                                                                                @foreach ($companies as $val)
                                                                                    <option
                                                                                        value="{{ $val->id }}">
                                                                                        {{ $val->company_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="field_errors"
                                                                                style="color: rgb(230, 33, 33)">
                                                                                @error('company_id')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    @else
                                                                        <input type="hidden" name="company_id"
                                                                            value="{{ isset($company_id) ? $company_id : '' }}">
                                                                    @endif
                                                                    <!--begin::Input group-->
                                                                    <div class="fv-row mb-10">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-5 fw-bold form-label mb-2">
                                                                            <span class="required">Role name</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input class="form-control form-control-solid"
                                                                            placeholder="Enter a role name"
                                                                            name="title"
                                                                            value="{{ old('title') }}" />
                                                                        <!--end::Input-->
                                                                        <span class="field_errors"
                                                                            style="color: rgb(230, 33, 33)">
                                                                            @error('title')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </span>
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                    <!--begin::Permissions-->
                                                                    <div class="fv-row">
                                                                        <!--begin::Label-->
                                                                        <label
                                                                            class="fs-5 fw-bold form-label mb-2">Role
                                                                            Permissions</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Table wrapper-->
                                                                        <div class="table-responsive">
                                                                            <!--begin::Table-->
                                                                            <table
                                                                                class="table align-middle table-row-dashed fs-6 gy-5">
                                                                                <!--begin::Table body-->
                                                                                <tbody
                                                                                    class="text-gray-600 fw-semibold">
                                                                                    <!--begin::Table row-->
                                                                                    <tr>
                                                                                        <td class="text-gray-800">
                                                                                            Administrator Access
                                                                                            <span class="ms-2"
                                                                                                data-bs-toggle="popover"
                                                                                                data-bs-trigger="hover"
                                                                                                data-bs-html="true"
                                                                                                data-bs-content="Allows a full access to the system">
                                                                                                <i
                                                                                                    class="ki-duotone ki-information fs-7">
                                                                                                    <span
                                                                                                        class="path1"></span>
                                                                                                    <span
                                                                                                        class="path2"></span>
                                                                                                    <span
                                                                                                        class="path3"></span>
                                                                                                </i>
                                                                                            </span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <!--begin::Checkbox-->
                                                                                            <label
                                                                                                class="form-check form-check-custom form-check-solid me-9">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    value=""
                                                                                                    id="kt_roles_select_all" />
                                                                                                <span
                                                                                                    class="form-check-label"
                                                                                                    for="kt_roles_select_all">Select
                                                                                                    all</span>
                                                                                            </label>
                                                                                            <!--end::Checkbox-->
                                                                                        </td>
                                                                                    </tr>
                                                                                    <!--end::Table row-->
                                                                                    @if (isset($all_permissions))
                                                                                        @foreach ($all_permissions as $key => $val)
                                                                                            <!--begin::Table row-->
                                                                                            <tr>
                                                                                                <!--begin::Label-->
                                                                                                <td
                                                                                                    class="text-gray-800">
                                                                                                    {{ $key }}
                                                                                                </td>
                                                                                                <!--end::Label-->
                                                                                                @if (!empty($val))
                                                                                                    @foreach ($val as $k => $v)
                                                                                                        <!--begin::Options-->
                                                                                                        <td>
                                                                                                            <!--begin::Wrapper-->
                                                                                                            <div
                                                                                                                class="d-flex">
                                                                                                                <!--begin::Checkbox-->
                                                                                                                <label
                                                                                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                                                                    <input
                                                                                                                        class="permission form-check-input"
                                                                                                                        type="checkbox"
                                                                                                                        value="{{ $k }}"
                                                                                                                        name="{{ $key . '_' . $v }}" />
                                                                                                                    <span
                                                                                                                        class="form-check-label">{{ $v }}</span>
                                                                                                                </label>
                                                                                                                <!--end::Checkbox-->
                                                                                                            </div>
                                                                                                            <!--end::Wrapper-->
                                                                                                        </td>
                                                                                                        <!--end::Options-->
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </tr>
                                                                                            <!--end::Table row-->
                                                                                        @endforeach
                                                                                    @endif
                                                                                </tbody>
                                                                                <!--end::Table body-->
                                                                            </table>
                                                                            <!--end::Table-->
                                                                        </div>
                                                                        <!--end::Table wrapper-->
                                                                    </div>
                                                                    <!--end::Permissions-->
                                                                </div>
                                                                <!--end::Scroll-->
                                                                <!--begin::Actions-->
                                                                <div class="text-center pt-15">
                                                                    <button type="reset" class="btn btn-light me-3"
                                                                        data-kt-roles-modal-action="cancel">Discard</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">{{-- data-kt-roles-modal-action="submit" --}}
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
                                            <!--end::Modal - Add role-->
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
                                        </div>
                                        <!--end::Content container-->
                                    </div>
                                    <!--end::Content-->
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
    <script src="assets/js/custom/apps/user-management/roles/list/add.js"></script>
    <script src="assets/js/custom/apps/user-management/roles/list/update-role.js"></script>
    @include('components.scripts')
    @yield('script')
    <script>
        $(document).ready(function() {
            $('#company').select2({
                width: '100%'
            });
        });
    </script>
</body>
<!--end::Body-->

</html>
