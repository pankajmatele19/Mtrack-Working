@extends('applications.applications')
@section('breadcrumb')
<!--begin::Item-->
<li class="breadcrumb-item">
    <span class="bullet bg-gray-400 w-5px h-2px"></span>
</li>
<!--end::Item-->
<!--begin::Item-->
<li class="breadcrumb-item text-muted"><a href="" class="text-muted text-hover-primary">{{(isset($edit_app_details) && $edit_app_details==true) ? 'Edit Application' : 'Add Application'}}</a></li>
<!--end::Item-->
@endsection
@section('action_btns_toolbar')
<a href="{{url('/applications')}}" class="btn btn-sm fw-bold btn-primary">Back</a>
@endsection
@section('application_page_content')
<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{(isset($edit_app_details) && $edit_app_details==true) ? 'Edit Application' : 'Add New Application'}}</h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_app_form" class="form" action="/application/add" method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Name" name="name" autocomplete="off" class="form-control bg-transparent" value="{{ (isset($app_details->app_name) && !empty($app_details->app_name)) ? $app_details->app_name : old('app_name') }}" required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </span>
                            <!--end::Name-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Description" name="description" autocomplete="off" class="form-control bg-transparent" value="{{ (isset($app_details->description) && !empty($app_details->description)) ? $app_details->description : old('description') }}" required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </span>
                            <!--end::Name-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-8">
                            <!--begin::Category-->
                            <select name="category_id" id="category" class="form-select bg-transparent">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ isset($app_details) && $app_details->category_id == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('category_id')
                                {{ $message }}
                                @enderror
                            </span>
                            <!--end::Category-->
                        </div>
                        <!--end::Input group-->
                        @if ($flag == 1)
                        <div class="col-md-12 mb-7">
                            <select name="company_id" id="company" style="cursor: pointer;" class="form-control form-select bg-transparent" {{ !$flag ? 'disabled' : '' }} required>
                                <option value="{{ $company_id }}" selected>{{ $company_name }}</option>
                                @foreach($companies as $company)
                                @if(isset($dept_details->company_id) && $dept_details->company_id == $company->id)
                                <option selected value="{{ $company->id }}">
                                    {{ $company->company_name }}
                                </option>
                                @else
                                <option value="{{ $company->id }}">
                                    {{ $company->company_name }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('company_id')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <!--begin::Actions-->
            <div class="text-center pt-10">
                <a href="{{url('/applications')}}" class="btn btn-light me-3">Discard</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">{{(isset($edit_app_details) && $edit_app_details==true) ? 'Update' : 'Save'}}</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#category').select2({
            width: "100%"
        });
    });
</script>
@endsection