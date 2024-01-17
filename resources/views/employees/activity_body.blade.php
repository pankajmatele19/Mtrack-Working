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
                    <!--end::Title-->
                    <!-- <a href="{{ route('employees.activity_ss', ['employee_id' => isset($apiData['employeeDetail']['id']) ? $apiData['employeeDetail']['id'] : 'N/A']) }}" class="btn btn-primary btn-sm">View Screen Captures</a> -->

                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-semibold fs-6 text-gray-400">Activity Chart</span>
                            </div>
                            <!-- The following div serves as the container for the bar chart -->
                            <div id="barChart" style="width: 100%; height: 50px;"></div>
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
                            </th>
                            <th>Non-Productive Applications</th>
                            <th>Total Usage Time (Hours)</th>
                            <th>Action</th>
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
                            <td><button class="btn btn-sm btn-light-primary btn-flex btn-center btn-active-primary">Mark as Productive</button></td>
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
            @if (!empty($apiDataSS['data']['screenCapture']) && is_array($apiDataSS['data']['screenCapture']))
            @php
            // Group screen captures by hour timestamp
            $screenCapturesByHour = [];
            foreach ($apiDataSS['data']['screenCapture'] as $capture) {
            $hour = date('H', strtotime($capture['activetimestamp']));
            $screenCapturesByHour[$hour][] = $capture;
            }
            @endphp

            {{-- Iterate over screen captures grouped by hour --}}
            @foreach ($screenCapturesByHour as $hour => $captures)
            <h5 class="mb-3">Hour: {{ $hour }}:00 - {{ $hour }}:59</h5>
            <div id="carousel{{ $hour }}" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @php
                    $totalPhotos = count($captures);
                    $photosPerPage = 3;
                    $numPages = ceil($totalPhotos / $photosPerPage);
                    @endphp

                    {{-- Iterate over pages within the current hour --}}
                    @for ($i = 0; $i < $numPages; $i++) <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        <div class="row">
                            {{-- Iterate over screen captures for the current page --}}
                            @for ($j = $i * $photosPerPage; $j < min(($i + 1) * $photosPerPage, $totalPhotos); $j++) <div class="col-md-4">
                                <div class="card">
                                    <div class="card-img">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-zoom-image="{{ $captures[$j]['imagedata'] }}">
                                            <img src="{{ $captures[$j]['imagedata'] }}" class="w-100" alt="Screen Capture">
                                        </a>
                                    </div>
                                </div>
                        </div>
                        @endfor
                </div>
            </div>
            @endfor
        </div>

        {{-- Add carousel controls if needed --}}
        <a class="carousel-control-prev" href="#carousel{{ $hour }}" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carousel{{ $hour }}" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>
    @endforeach
    @else
    <p>No screen captures available.</p>
    @endif
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
<!--begin::Navbar-->

<script>
    // Update the modal image when an image is clicked
    $(document).on('click', '[data-bs-target="#imageModal"]', function() {
        var imgSrc = $(this).find('img').attr('src');
        $('#modalImage').attr('src', imgSrc);
    });
</script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Active', 'Inactive'],
            [, <?php echo isset($apiData['data']['workingDuration']) ? $apiData['data']['workingDuration'] / 3600 : 0; ?>, <?php echo isset($apiData['data']['totalNonProductiveTimeusage']) ? $apiData['data']['totalNonProductiveTimeusage'] / 3600 : 0; ?>]
        ]);

        var options = {
            chartArea: {
                left: 10,
                top: 5,
                width: '70%',
                height: '50%'
            },
            isStacked: true,
            legend: {
                position: 'none'
            },
            colors: ['green', 'red']
        };

        var chartContainer = document.getElementById('barChart');

        if (chartContainer) {
            var chart = new google.visualization.BarChart(chartContainer);
            chart.draw(data, options);
        }
    }
</script>