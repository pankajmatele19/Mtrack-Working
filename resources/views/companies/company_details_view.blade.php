<div class="row">
    <style>
        .view_company_logo{
            width: 100%;
            border: 1px solid;
            border-radius: 1vmax;
            border-color: #d3eaff;
        }
    </style>
    @if ($flag == 1)
        <div class="col-md-12 text-center">
            <div class="col-md-12 mb-7">
                <h3> <u>{{ $comp_details->company_name }} </u></h3>
            </div>
        </div>
    @endif
    <div class="col-md-4 mb-8">
        {{-- <div class="row"> --}}
            <div>
                <img class="view_company_logo" src="{{(isset($comp_details->company_logo) && !empty($comp_details->company_logo)) ? url($comp_details->company_logo) : ''}}" alt="image">
            </div>
            {{-- <div class="col-md-12 mb-7">
                <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                <div class="image-input image-input-outline image-input-placeholder {{(isset($comp_details->company_logo) && !empty($comp_details->company_logo)) ? '' : 'image-input-empty'}}" data-kt-image-input="true">
                    <div class="image-input-wrapper w-150px h-150px" style="background-image: {{(isset($comp_details->company_logo) && !empty($comp_details->company_logo)) ? 'url('.$comp_details->company_logo.')' : 'none'}};"></div>
                </div>
            </div> --}}
        {{-- </div> --}}
    </div>
    <div class="col-md-8">
        <div class="fv-row mb-5">
            <h4>About Company:</h4>
            <a href="{{$comp_details->company_website}}">{{ (isset($comp_details->company_website) && !empty($comp_details->company_website)) ? $comp_details->company_website : ''}}</a>
        </div>
        <div class="fv-row mb-5">
            <h4>About Company:</h4>
            <p>{{ (isset($comp_details->about_company) && !empty($comp_details->about_company)) ? $comp_details->about_company : ''}}</p>
        </div>
        <div class="fv-row mb-5">
            <h4>Company Address:</h4>
            <p>{{ (isset($comp_details->company_address) && !empty($comp_details->company_address)) ? $comp_details->company_address : ''}}</p>
        </div>
        <div class="fv-row mb-5">
            <h4>Total Employees: {{ (isset($comp_details->employees_count) && !empty($comp_details->employees_count)) ? $comp_details->employees_count : ''}}</h4>
        </div>

        <div class="fv-row mb-5">
            <h4>Contact Name: {{ (isset($comp_details->contact_name) && !empty($comp_details->contact_name)) ? $comp_details->contact_name : ''}}</h4>
        </div>

        <div class="fv-row mb-5">
            <h4 style="color: #2584ff;">Contact Email: {{ (isset($comp_details->contact_email) && !empty($comp_details->contact_email)) ? $comp_details->contact_email : ''}}</h4>
        </div>
        <div class="fv-row mb-5">
            <h4>Contact Number: {{ (isset($comp_details->contact_phone) && !empty($comp_details->contact_phone)) ? $comp_details->contact_phone : ''}}</h4>
        </div>
    </div>
</div>
<div class="text-center pt-10">
    <a href="{{url('/company/edit').'/'.$comp_details->id}}" class="btn btn-primary me-3">Edit</a>
</div>
