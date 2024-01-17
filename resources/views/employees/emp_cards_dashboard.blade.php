@php
$total_emp = count($employees);
@endphp

<!--begin::Item-->
<!--begin::emp_card-->
<div class="row g-6 g-xl-9">
    @foreach ($employees as $key => $val)
    <!--begin::Col-->
    <div class="col-md-3">
        <!--begin::Card-->
        <div class="card emp_card" style="flex: 0 0 calc(25% - 10px); position: relative;" draggable="true">
            <!--begin::Card body-->
            <div class="card-body d-flex flex-column p-9">
                <!--begin::Top Row-->
                <div class="d-flex justify-content-between align-items-center  mb-4">
                    <!--begin::Email-->
                    <div class="text-gray-800 fw-bold">
                        {{ !empty($val->email) ? $val->email : 'unknown' }} <!-- Replace with the employee's email -->
                    </div>
                    <!--end::Email-->

                    <!--begin::Watch Live Button-->
                    <div class="to-hide-live">
                        <button data-emp-id="{{ $val->id }}" class="view-screen btn btn-sm btn-light-primary fw-bold">Live</button>
                        <!--end::Watch Live Button-->
                    </div>
                </div>
                <!--end::Top Row-->
                <div class="to-hide">
                    <!--begin::Avatar-->
                    <div class="mb-5 d-flex justify-content-center">
                        <div class="symbol symbol-75px symbol-circle">
                            @if(!empty($val->profile_pic))
                            <img alt="Profile Picture" src="{{ $val->profile_pic }}" />
                            @else
                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 L7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                </g>
                                </svg>
                            </span>
                            @endif
                        </div>
                    </div>
                    <!--end::Avatar-->

                    <!--begin::Name-->
                    <div class="text-center mb-3">
                        <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bold">{{ !empty($val->name) ? $val->name : 'unknown' }}</a>
                    </div>
                    <!--end::Name-->

                    <!--begin::Position-->
                    <div class="text-center fw-semibold text-gray-400 mb-6">Software Developer</div>
                    <!--end::Position-->
                </div>
                <!--Video-->
                <div id="video-container_{{ $val->id }}"></div>
                <!--begin::Started Time-->
                <div class="mt-auto text-gray-400">Started at:- {{ !empty($val->started_at) ? \Carbon\Carbon::parse($val->started_at)->format('g:i A') : 'Unknown' }}</div>
                <!-- This is just a placeholder. Replace "9:00 AM" with the actual start time. -->
                <!--end::Started Time-->
            </div>
            <!--end::Card body-->
            <div class="resizer" style="width: 20px; height: 20px; background-color: #ccc; position: absolute; bottom: 0; right: 0; cursor: nwse-resize;">
            </div>
        </div>
        <!--end::Card-->
    </div>

    @endforeach
    <!--end::Col-->
</div>
<!--end::emp_card-->
<!--end::Item-->