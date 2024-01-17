<!DOCTYPE html>
<html lang="en">
{{-- head_tag --}}
@include('components.head_tag')
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!-- Loader -->
    <div id="loader" class="loader-container">
        <div class="spinner loading-spinner text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

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
                                        Activity Details</h1>
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
                                            <a href="#" id="breadcrumb-id" class="text-muted text-hover-primary">Activity of ID {{ isset($apiData['employeeDetail']['id']) ? $apiData['employeeDetail']['id'] : 'N/A' }}</a>
                                        </li>
                                        <!--end::Item-->
                                    </ul>
                                    <!--end::Breadcrumb-->
                                </div>

                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <!--begin::Filter menu-->
                                <div class="m-0">
                                    <input type="text" id="custom_date_range" class="form-control">


                                </div>

                                <!--end::Filter menu-->
                                <!--end::Actions-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->
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
                                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative" style="border: 1px solid; border-color:#cee4fa;">
                                                    <img src="{{ !empty($apiData['employeeDetail']['profile_pic']) ? $apiData['employeeDetail']['profile_pic'] : '' }}" alt="image" />
                                                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Pic-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <!--begin::Title-->
                                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center mb-2">
                                                            <a href="{{ url('/myprofile') }}" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ !empty($apiData['employeeDetail']['name']) ? $apiData['employeeDetail']['name'] : 'unknown' }}</a>
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
                                                            <a href="{{ url('/myprofile') }}" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                                    <span class="path1"></span>
                                                                    <span class "path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                                {{ !empty($apiData['data']['role']['title']) ? $apiData['data']['role']['title'] : 'unknown' }}
                                                            </a>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!-- <a href="{{ route('employees.activity_ss', ['employee_id' => isset($apiData['employeeDetail']['id']) ? $apiData['employeeDetail']['id'] : 'N/A']) }}" class="btn btn-primary btn-sm">View Screen Captures</a> -->

                                                <!--end::Title-->
                                                <!--begin::Stats-->
                                                <div class="d-flex flex-wrap flex-stack">
                                                    <!--begin::Progress-->
                                                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                            <span class="fw-semibold fs-6 text-gray-400">Activity Chart</span>
                                                            <span class="fw-bold fs-6">
                                                                @if (isset($apiData['data']['workingDuration']))
                                                                {{ number_format($apiData['data']['workingDuration'] / 3600, 3) }} hours
                                                                @else
                                                                N/A
                                                                @endif
                                                            </span>

                                                        </div>
                                                        <!-- <a id="barchart" href=""></a> -->
                                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                            @php
                                                            $valueNow = isset($apiData['data']['workingDuration']) && isset($apiData['data']['totalNonProductiveTimeusage']) ? ($apiData['data']['workingDuration'] - $apiData['data']['totalNonProductiveTimeusage']) / 3600 : 0;
                                                            $valueMin = isset($apiData['data']['totalNonProductiveTimeusage']) ? $apiData['data']['totalNonProductiveTimeusage'] / 3600 : 0;
                                                            $valueMax = isset($apiData['data']['workingDuration']) ? $apiData['data']['workingDuration'] / 3600 : 0;
                                                            @endphp
                                                            <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ $valueNow > 0 ? ($valueNow / $valueMax * 100) : 0 }}%;" aria-valuenow="{{ $valueNow }}" aria-valuemin="{{ $valueMin }}" aria-valuemax="{{ $valueMax }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Progress-->
                                                </div>


                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Details-->

                                        <!--end::Details-->
                                    </div>
                                </div>
                                <!--end::Navbar-->
                                <!--begin::Activity info-->
                                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card-header">
                                        <h3 class="card-title">Non-Productive Hours</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead style="font-weight: bold;
    background-color: #f7f7f7; text-align:center;">
                                                    <tr>
                                                        <th class="w-10px pe-2">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_table .form-check-input" value="" />
                                                            </div>
                                                        </th>
                                                        <th>Non-Productive Applications</th>
                                                        <th>Total Usage Time (Hours)</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="text-align: center;">
                                                    @if (isset($apiData['data']['nonProductiveApplications']) && is_array($apiData['data']['nonProductiveApplications']))
                                                    @foreach ($apiData['data']['nonProductiveApplications'] as $app)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" />
                                                            </div>
                                                        </td>
                                                        <td>{{ $app['title'] ?? 'N/A' }}</td>
                                                        <td>{{ isset($app['totalUsageTime']) ? number_format($app['totalUsageTime'] / 3600, 3) : 'N/A' }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="2">No non-productive applications data available.</td>
                                                    </tr>
                                                    @endif

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Activity info-->
                                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                                    <div class="card-header">
                                        <h3 class="card-title">Screen Captures</h3>
                                    </div>
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap flex-sm-nowrap">
                                            <div class="container text-center my-3" style="overflow-x: auto !important; white-space: nowrap;">
                                                <div class="row mx-auto my-auto justify-content-center">
                                                    <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner" role="listbox">
                                                            @if (!empty($apiData['data']['screenCapture']) && is_array($apiData['data']['screenCapture']))
                                                            @foreach ($apiData['data']['screenCapture'] as $index => $capture)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="card">
                                                                            <div class="card-img">
                                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-zoom-image="{{ $capture['imagedata'] }}">
                                                                                    <img src="{{ $capture['imagedata'] }}" class="w-100" alt="Screen Capture {{ $index + 1 }}">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @else
                                                            <p>No screen captures available.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev bg-transparent w-auto" href="#recipeCarousel" role="button" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    </a>
                                                    <a class="carousel-control-next bg-transparent w-auto" href="#recipeCarousel" role="button" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Modal for Image Display with Zoom -->
                                        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 90%;">
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
    @include('components.scripts')

    @yield('script')
    <!-- Custom JavaScript code to handle the filter form -->

    <!-- <script>
        $(document).ready(function() {
            // Initialize the Metronic Date Range Picker
            $('#custom_date_range').daterangepicker({
                buttonClasses: 'btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '2 Days Ago': [moment().subtract(2, 'days'), moment().subtract(2, 'days')],
                }
            });

            // Handle filter option selection
            // Handle filter option selection
            $(".dropdown-item").click(function(e) {
                e.preventDefault();
                var selectedOption = $(this).attr("data-filter-option");
                console.log("Selected Option: " + selectedOption); // Log the selected option
                $("#filter_option").val(selectedOption);
                $("#filterDropdown").html($(this).text());

                // Trigger the predefined date range based on the selected option
                if (selectedOption === "1") {
                    $('#custom_date_range').data('daterangepicker').setStartDate(moment());
                    $('#custom_date_range').setEndDate(moment());
                } else if (selectedOption === "2") {
                    var yesterday = moment().subtract(1, 'days');
                    $('#custom_date_range').data('daterangepicker').setStartDate(yesterday);
                    $('#custom_date_range').setEndDate(yesterday);
                } else if (selectedOption === "3") {
                    // Handle the "Custom" option as needed
                    // You can leave it as is since the user can manually select the custom date range
                }

                // Send the selected filterOption to the activity function
                $.get('/activity/' + employee_id, {
                    filter_option: selectedOption
                }, function(data) {
                    // Handle the response if needed
                });
            });



        });
    </script> -->
    <script>
        // Update the modal image when an image is clicked
        $(document).on('click', '[data-bs-target="#imageModal"]', function() {
            var imgSrc = $(this).find('img').attr('src');
            $('#modalImage').attr('src', imgSrc);
        });
    </script>
    <script>
        function showLoader() {
            $('body').addClass('loading'); // Add a class to show the loader and apply faded background
            $('#loader').addClass('show'); // Add a class to show the loader
        }

        function hideLoader() {
            $('body').removeClass('loading'); // Remove the class to hide the faded background
            $('#loader').removeClass('show'); // Remove the class to hide the loader
        }
        $(document).ready(function() {
            // Initialize the Metronic Date Range Picker
            var dateRangePicker = $('#custom_date_range').daterangepicker({
                buttonClasses: 'btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '2 Days Ago': [moment().subtract(2, 'days'), moment().subtract(2, 'days')],
                }
            });
            $('#custom_date_range').val('Today');
            // When a predefined range is clicked, update the input box
            dateRangePicker.on('apply.daterangepicker', function(ev, picker) {
                $('#custom_date_range').val(picker.chosenLabel);
            });
            $("#custom_date_range").on('change', function(e) {
                e.preventDefault();
                showLoader(); // Show loader before making AJAX call
                var selectedDate = $(this).val(); // Get the selected date
                console.log("Selected Date: " + selectedDate);
                // Make an AJAX call to the current URL with the selected date as a query parameter
                $.ajax({
                    type: 'GET',
                    url: "{{ url()->current() }}", // Use the current URL
                    data: {
                        selectedDate: selectedDate
                    },
                    success: function(response) {

                        hideLoader(); // Hide loader after AJAX call is complete
                        $('#kt_app_content').html(response['html']);
                        $('#breadcrumb-id').text("Activity of ID " + response['breadcrumb_id']);
                        $('#custom_date_range').val(response['selectedDate']);
                        // When a predefined range is clicked, update the input box
                        dateRangePicker.on('apply.daterangepicker', function(ev, picker) {
                            $('#custom_date_range').val(picker.chosenLabel);
                        });
                    },
                    error: function(err) {
                        console.error("AJAX Error: " + err);
                        hideLoader(); // Hide loader after AJAX call is complete
                    }
                });

            });
        });
    </script>




</body>

</html>