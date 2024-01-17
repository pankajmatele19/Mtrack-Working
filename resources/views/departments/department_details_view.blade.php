<div class="row">
    <style>
        .view_department_logo {
            width: 100%;
            border: 1px solid;
            border-radius: 1vmax;
            border-color: #d3eaff;
        }
    </style>
    @if ($flag == 1)
        <div class="col-md-12 text-center">
            <div class="col-md-12 mb-7">
                <h3> <u>{{ $dept_details->department_name }} </u></h3>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <div class="col-md-12 mb-7">
                <h5> <u>{{ $dept_details->company_name }} </u></h5>
            </div>
        </div>
    @endif
    <div class="col-md-8">
        <div class="fv-row mb-5">
            <h4>About department:</h4>
            <p">{{ isset($dept_details->department_desc) && !empty($dept_details->department_desc) ? $dept_details->department_desc : '' }}
                </p>
        </div>
    </div>
</div>
<div class="text-center pt-10">
    <a href="{{ url('/department/edit') . '/' . $dept_details->id }}" class="btn btn-primary me-3">Edit</a>
</div>
