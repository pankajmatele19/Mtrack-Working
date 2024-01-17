@php
$count = 1;
$total_emp = count($employees);
@endphp
@foreach ($employees as $key => $val)
@if ($count == 1)
<!--begin::Item-->
<div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
    <!--begin::Wrapper-->
    <div class="carousel-wrapper">
        <!--begin::emp_card-->
        <div class="row g-6 g-xl-9">
            @endif
            <!--begin::Col-->
            <div class="col-md-3" style="margin-bottom: 5px !important;">
                <!--begin::Card-->
                <div class="card emp_card">
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-center flex-column p-9">
                        <!--begin::Wrapper-->
                        <div class="mb-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-75px symbol-circle">
                                <img alt="Pic" src="{{ !empty($val->profile_pic) ? $val->profile_pic : '/assets/media/svg/avatars/blank.svg' }}" />
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Name-->
                        <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ !empty($val->name) ? $val->name : 'unknown' }}</a>
                        <!--end::Name-->
                        <!--begin::Position-->
                        <div class="fw-semibold text-gray-400 mb-6">{{ !empty($val->email) ? $val->email : 'unknown' }}
                        </div>
                        <!--end::Position-->
                        <!--begin::Info-->
                        <div class="d-flex flex-center flex-wrap mb-5">

                        </div>
                        <!--end::Info-->
                        <!--begin::Link-->
                        <button data-emp-id="{{ $val->id }}" data-user-id="{{ $val->id }}" class="view-screen btn btn-sm btn-light-primary fw-bold">Live</button>
                        <!--end::Link-->
                    </div>
                    <!--begin::Card body-->
                </div>
                <!--begin::Card-->
            </div>
            <!--end::Col-->
            @if ($total_emp / 4 >= 1 && $count == 4)
        </div>
        <!--end::emp_card-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Item-->
@elseif ($total_emp == $count)
</div>
<!--end::emp_card-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Item-->
@endif
@php
$count++;
if ($count > 4) {
$count = 1;
}

@endphp
@endforeach