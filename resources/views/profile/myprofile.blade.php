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
                                        My Profile</h1>
                                    <!--end::Title-->
                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="" class="text-muted text-hover-primary">Home</a>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted"><a href="{{ url('/myprofile') }}"
                                                class="text-muted text-hover-primary">My Profile</a></li>
                                        <!--end::Item-->
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">

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
                                <!--begin::Navbar-->
                                <div class="card mb-5 mb-xl-10">
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap flex-sm-nowrap">
                                            <!--begin: Pic-->
                                            <div class="me-7 mb-4">
                                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"
                                                    style="border: 1px solid; border-color:#cee4fa;">
                                                    <img src="{{ !empty($user->profile_pic) ? $user->profile_pic : '' }}"
                                                        alt="image" />
                                                    <div
                                                        class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Pic-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <!--begin::Title-->
                                                <div
                                                    class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center mb-2">
                                                            <a href="{{ url('/myprofile') }}"
                                                                class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ !empty($user->name) ? $user->name : 'unknown' }}</a>
                                                            <a href="{{ url('/myprofile') }}">
                                                                <i class="ki-duotone ki-verify fs-1 text-primary">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </a>
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Info-->
                                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                            <a href="{{ url('/myprofile') }}"
                                                                class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                                {{ !empty($role->title) ? $role->title : 'unknown' }}
                                                            </a>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Title-->
                                                <!--begin::Stats-->
                                                <div class="d-flex flex-wrap flex-stack">
                                                    <!--begin::Progress-->
                                                    <div
                                                        class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                            <span class="fw-semibold fs-6 text-gray-400">Profile
                                                                Compleation</span>
                                                            <span class="fw-bold fs-6">50%</span>
                                                        </div>
                                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                            <div class="bg-success rounded h-5px" role="progressbar"
                                                                style="width: 50%;" aria-valuenow="50" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <!--end::Progress-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Navs-->
                                        <ul
                                            class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                            {{-- <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->is('myprofile') ? 'active' : '' }}"
                                                    href="{{ url('/myprofile') }}">Overview</a>
                                            </li>
                                            <!--end::Nav item--> --}}
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->is('myprofile') ? 'active' : '' }}"
                                                    href="{{ url('/myprofile') }}">Personal Info</a>
                                            </li>
                                            <!--end::Nav item-->
                                            @if ($flag != 1)
                                                <!--begin::Nav item-->
                                                <li class="nav-item mt-2">
                                                    <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->is('company') ? 'active' : '' }}"
                                                        href="{{ url('/company') }}">Company</a>
                                                </li>
                                                <!--end::Nav item-->
                                            @endif
                                        </ul>
                                        <!--begin::Navs-->
                                    </div>
                                </div>
                                <!--end::Navbar-->
                                {{-- @if (request()->is('myprofile'))
                                    @include('profile.profile_details_view') --}}
                                @if (request()->is('myprofile'))
                                    @include('profile.edit_profile')
                                    @if ($user->is_company_super_admin == 1)
                                        @include('profile.company')
                                    @endif
                                    {{-- @elseif(request()->is('company')) --}}
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
    <script src="assets/js/custom/account/settings/signin-methods.js"></script>

    @yield('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#reset_password_btn', function(e) {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you want to reset password",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, reset!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function(result) {
                    if (result.value) {
                        $('#kt_account_profile_details_form').append(
                            '<input type="hidden" name="reset_password" value="reset_password">'
                        );
                        $('#kt_account_profile_details_form').submit();
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: recordTitle + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
<!--end::Body-->

</html>
