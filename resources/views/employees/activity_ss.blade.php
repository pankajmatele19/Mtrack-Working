<!DOCTYPE html>
<html lang="en">
{{-- head_tag --}}
@include('components.head_tag')
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
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
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                        Activity Screen Captures</h1>
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
                                        <li class="breadcrumb-item text-muted"><a href="{{ url('/employees') }}" class="text-muted text-hover-primary">Employees</a></li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="#" id="breadcrumb-id" class="text-muted text-hover-primary">Activity Screen Capture of ID {{ isset($employee_id) ? $employee_id : 'N/A' }}</a>

                                        </li>
                                        <!--end::Item-->
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>

                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <!--begin::Filter menu-->
                                <!-- <div class="m-0">
                                    <input type="text" id="custom_date_range" class="form-control">
                                </div> -->
                                <!--end::Filter menu-->
                                <!--end::Actions-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!-- Add this code inside your Blade view, within the appropriate container or section -->


                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-xxl">
                                <!--begin::Navbar-->
                                <div class="card mb-5 mb-xl-10">
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap flex-sm-nowrap">
                                            <!-- Add this code inside your Blade view, within the appropriate container or section -->

                                            <div class="container">
                                                <div class="row">
                                                    @foreach($apiData['data']['screenCapture'] as $photoUrl)
                                                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                                                        <div class="card">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-zoom-image="{{ $photoUrl }}">
                                                                <img src="{{ $photoUrl }}" class="card-img-top" alt="Screen Capture">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Modal for Image Display with Zoom -->
                                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="" id="modalImage" class="img-fluid zoomable" alt="Image Preview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('components.footer')
            </div>
        </div>
    </div>
    @include('components.scripts')
    @yield('script')
    <script>
        // Update the modal image when an image is clicked
        $(document).on('click', '[data-bs-target="#imageModal"]', function() {
            var imgSrc = $(this).find('img').attr('src');
            $('#modalImage').attr('src', imgSrc);
        });
    </script>
    <!-- <script>
        // Initialize Bootstrap Image Zoom on images within the modal
        $('#imageModal').on('shown.bs.modal', function() {
            $('[data-bs-zoomable="true"]').bootstrapImgZoom();
        });

        // Update the modal image when an image is clicked
        $(document).on('click', '[data-bs-target="#imageModal"]', function() {
            var imgSrc = $(this).find('img').attr('src');
            $('#modalImage').attr('src', imgSrc);
        });
    </script> -->
</body>