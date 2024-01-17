<div class="row">
    @if ($flag == 1)
    <div class="col-md-12 text-center">
        <div class="col-md-12 mb-7">
            @foreach ($companies as $val)
            @if(isset($emp_details->company_id) && $emp_details->company_id==$val->id)
            <h3> {{ $val->company_name }} </h3>
            @endif
            @endforeach
        </div>
    </div>
    @endif
    <div class="col-md-2">
        <div class="row">
            {{-- <div class="symbol symbol-100px symbol-circle mb-7">
                <img src="{{(isset($emp_details->profile_pic) && !empty($emp_details->profile_pic)) ? url($emp_details->profile_pic) : ''}}}}" alt="image">
        </div> --}}
        <div class="col-md-12 mb-7">
            <style>
                .image-input-placeholder {
                    background-image: url('assets/media/svg/files/blank-image.svg');
                }

                [data-bs-theme="dark"] .image-input-placeholder {
                    background-image: url('assets/media/svg/files/blank-image-dark.svg');
                }
            </style>
            <div class="image-input image-input-outline image-input-placeholder {{(isset($emp_details->profile_pic) && !empty($emp_details->profile_pic)) ? '' : 'image-input-empty'}}" data-kt-image-input="true">
                <div class="image-input-wrapper w-150px h-150px" style="background-image: {{(isset($emp_details->profile_pic) && !empty($emp_details->profile_pic)) ? 'url('.$emp_details->profile_pic.')' : 'none'}};"></div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="fv-row">
        <h4>{{ (isset($emp_details->name) && !empty($emp_details->name)) ? 'Name: '.$emp_details->name : '-'}}</h4>
    </div>

    <div class="fv-row">
        <h4 style="color: #2584ff;">{{ (isset($emp_details->email) && !empty($emp_details->email)) ? 'Email: '.$emp_details->email : '-'}}</h4>
    </div>
    <div class="fv-row">
        <h4>{{ (isset($emp_details->phone) && !empty($emp_details->phone)) ? 'Phone: '.$emp_details->phone : '-'}}</h4>
    </div>
</div>
</div>
<hr style="border-top: 1px dashed;">
@if(isset($settings))
<h3 class="mb-5">Settings</h3>
<div class="row">
    @foreach ($settings as $key=>$val)
    <div class="col-md-6 mb-5">
        <div class="notice {{(!in_array('interval',array_keys($val)) && isset($val['value']) && $val['value']==1) ? 'bg-light-primary' : ''}} d-flex rounded border-primary border border-dashed p-3">
            <div class="row">
                <div class="{{(in_array('interval',array_keys($val))) ? 'col-md-8':'col-md-10'}}">
                    <div class="fs-7 text-gray-700">
                        <h6>{{$val['title']}}</h6>
                        <span>{{$val['description']}}</span>
                    </div>
                </div>
                @if (in_array('interval',array_keys($val)))
                <div class="col-md-4 text-end my-auto">
                    <input type="number" class="form-control bg-transparent" name="{{$key}}" id="{{$key}}" value="{{$val['value']}}">
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
<div class="text-center pt-10">
    <a href="{{url('/employee/edit').'/'.$emp_details->id}}" class="btn btn-primary me-3">Edit</a>
</div>