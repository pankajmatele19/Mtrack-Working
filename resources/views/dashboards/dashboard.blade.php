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
                            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                    <!--begin::Title-->
                                    <h1
                                        class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        Multipurpose</h1>
                                    <!--end::Title-->
                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="../../demo1/dist/index.html"
                                                class="text-muted text-hover-primary">Home</a>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">Dashboards</li>
                                        <!--end::Item-->
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <!--begin::Secondary button-->
                                    <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_app">Rollover</a>
                                    <!--end::Secondary button-->
                                    <!--begin::Primary button-->
                                    <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_new_target">Add Target</a>
                                    <!--end::Primary button-->
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <!--begin::Carousel-->
                                <div id="kt_security_guidelines" class="carousel carousel-custom carousel-stretch slide"
                                    data-bs-ride="carousel" data-bs-interval="8000">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack align-items-center flex-wrap">
                                        <h3 class="fw-bold my-2">Employees</h3>
                                        <!--begin::Carousel Indicators-->
                                        @include('dashboards.carousel-indicators')
                                        <!--end::Carousel Indicators-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Carousel inner-->
                                    <div class="carousel-inner pt-6">
                                        @include('dashboards.emp_cards_dashboard')
                                        {{-- <!--begin::Item-->
                                        <div class="carousel-item active">
                                            <!--begin::Wrapper-->
                                            <div class="carousel-wrapper">
                                                <!--begin::emp_card-->
                                                <div class="row g-6 g-xl-9">
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::emp_card-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="carousel-item">
                                            <!--begin::Wrapper-->
                                            <div class="carousel-wrapper">
                                                <!--begin::emp_card-->
                                                <div class="row g-6 g-xl-9">
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::emp_card-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="carousel-item">
                                            <!--begin::Wrapper-->
                                            <div class="carousel-wrapper">
                                                <!--begin::emp_card-->
                                                <div class="row g-6 g-xl-9">
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-3">
                                                        <!--begin::Card-->
                                                        <div class="card emp_card">
                                                            <!--begin::Card body-->
                                                            <div class="card-body d-flex flex-center flex-column p-9">
                                                                <!--begin::Wrapper-->
                                                                <div class="mb-5">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-75px symbol-circle">
                                                                        <img alt="Pic"
                                                                            src="assets/media/avatars/300-6.jpg" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                                <!--begin::Name-->
                                                                <a href="#"
                                                                    class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Emma
                                                                    Smith</a>
                                                                <!--end::Name-->
                                                                <!--begin::Position-->
                                                                <div class="fw-semibold text-gray-400 mb-6">Art
                                                                    Director
                                                                </div>
                                                                <!--end::Position-->
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-center flex-wrap mb-5">

                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <button class="btn btn-sm btn-light-primary fw-bold"
                                                                    data-kt-drawer-show="true"
                                                                    data-kt-drawer-target="#kt_drawer_chat">Send
                                                                    Message</button>
                                                                <!--end::Link-->
                                                            </div>
                                                            <!--begin::Card body-->
                                                        </div>
                                                        <!--begin::Card-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::emp_card-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Item--> --}}
                                    </div>
                                    <!--end::Carousel inner-->
                                </div>
                                <!--end::Carousel-->
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Modal - employee_screen-->
                    <div class="modal fade" id="kt_modal_view_employee_screening" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header" id="kt_modal_view_employee_screening_header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Employee Screening</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div id="kt_modal_close_view_employee_screening"
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
                                <div class="modal-body" id="kt_modal_view_employee_screening_scroll">
                                    <div id="video-grid">
                                        {{-- <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/Kd2P-1FY4Hc?si=WhgAJWVifnqEq-c3"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe> --}}
                                    </div>
                                </div>
                                <!--end::Modal body-->
                            </div>
                        </div>
                    </div>
                    <!--end::Modal - employee_screen-->

                    @include('components.footer')

                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    <!--begin::Drawers-->
    <!--end::Drawers-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->
    @include('components.scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view-screen', function() {
                $('#kt_modal_view_employee_screening').modal('show');
            });

            $(document).on('click', '#kt_modal_close_view_employee_screening', function(e) {
                e.preventDefault();
                $('#video-grid').empty();
                $('#kt_modal_view_employee_screening').modal('hide');
            });
        });
    </script>
    <script>
        const mypeer = new Peer({
            host: "peer.m360tracker.com",
            secure: true,
            path: "/mtrack",
        });
        console.log("🚀 ~ file: index.html:34 ~ mypeer:", mypeer)

        // const viewscreen = document.getElementById("view-screen");
        // viewscreen.addEventListener("click", viewUserScreen);

        function createEmptyVideoTrack({
            width,
            height
        }) {
            const canvas = document.createElement("canvas");
            canvas.width = width;
            canvas.height = height;

            const context = canvas.getContext("2d");
            context.fillStyle = "black"; // Fill the canvas with black color
            context.fillRect(0, 0, width, height);

            const stream = canvas.captureStream(0); // Capture the canvas as a video stream
            const videoTrack = stream.getVideoTracks()[0];

            videoTrack.enabled = false; // Mute the video track

            return videoTrack;
        }

        $(document).on('click', '.view-screen', function() {
            var emp_id = $(this).attr('data-emp-id');
            var jwt_token;
            $.ajax({
                type: "GET",
                url: "",
                data: {
                    emp_id: emp_id,
                    page: "get_secret"
                },
                success: function(response) {
                    jwt_token = response['jwt_token'];
                    viewUserScreen(emp_id, jwt_token);
                }
            });
        });

        function viewUserScreen(emp_id, jwt_token) {
            const token = jwt_token;
            const socket = io.connect("https://api.m360tracker.com", {
                query: `token=${token}`
            });

            socket.on("connect", () => {
                try {
                    console.log(socket);
                    socket.emit("join room", {
                        employee_id: emp_id,
                    });

                    socket.on("user-connected", async (targetpeerid) => {
                        try {
                            // Create a MediaStream with both audio and video tracks
                            const videoTrack = createEmptyVideoTrack({
                                width: 500,
                                height: 500,
                            });
                            const stream = new MediaStream([videoTrack]);


                            console.log("user connected", targetpeerid);
                            const call = mypeer.call(targetpeerid, stream);

                            call.on("stream", (remotemediastream) => {
                                console.log(
                                    "🚀 ~ file: index.html:41 ~ socket.on ~ remotemediastream:",
                                    remotemediastream
                                );
                                const video = document.createElement("video");
                                video.classList.add('emp_screen');
                                addVideoStream(video, remotemediastream);
                            });

                            call.on("error", function(err) {
                                console.log(err);
                            });
                        } catch (error) {
                            console.log(error);
                        }
                    });
                } catch (error) {
                    console.log(error);
                }
            });
        }

        const addVideoStream = (video, userVideoStream) => {
            const videoGrid = document.getElementById("video-grid");
            console.log(
                "🚀 ~ file: index.html:41 ~ addVideoStream ~ userVideoStream:",
                userVideoStream
            );
            video.srcObject = userVideoStream;
            video.addEventListener("loadedmetadata", () => {
                video.play();
            });
            videoGrid.append(video);
        };
    </script>
</body>
<!--end::Body-->

</html>
