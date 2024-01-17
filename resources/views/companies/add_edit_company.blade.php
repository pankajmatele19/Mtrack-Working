@extends('companies.companies')
@section('breadcrumb')
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted"><a href=""
            class="text-muted text-hover-primary">{{ isset($edit_comp_details) && $edit_comp_details == true ? 'Edit Company' : 'Add Company' }}</a>
    </li>
    <!--end::Item-->
@endsection
@section('action_btns_toolbar')
    <a href="{{ url('/companies') }}" class="btn btn-sm fw-bold btn-primary">Back</a>
@endsection
@section('company_page_content')
    <div class="card">
        <div class="card-header mx-auto pt-6">
            <h2>{{ isset($edit_comp_details) && $edit_comp_details == true ? 'Edit Company' : 'Add New Company' }}</h2>
        </div>
        <div class="card-body">
            <!--begin::Form-->
            <form id="add_edit_company_form" class="form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <!--begin::Scroll-->
                <div class="row">
                    <!--begin::Input group-->
                    <div class="col-md-4 mb-7">
                        <div class="row">
                            <div class="col-md-12 mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">Company Logo</label>
                                <!--end::Label-->
                                <!--begin::Image placeholder-->
                                <style>
                                    .image-input-placeholder {
                                        background-image: url('assets/media/svg/files/blank-image.svg');
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                    }
                                </style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline image-input-placeholder {{ isset($comp_details->company_logo) && !empty($comp_details->company_logo) ? '' : 'image-input-empty' }}"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-250px h-250px"
                                        style="background-image: {{ isset($comp_details->company_logo) && !empty($comp_details->company_logo) ? 'url(' . $comp_details->company_logo . ')' : 'none' }};">
                                    </div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="company_logo" accept=".png, .jpg, .jpeg"
                                            value="{{ isset($comp_details->company_logo) && !empty($comp_details->company_logo) ? $comp_details->company_logo : '' }}" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                <!--end::Hint-->
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('company_logo')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="col-md-8">
                        <div class="row">
                            <!--begin::Input group-->
                            <div class="fv-row mb-8">
                                <!--begin::Name-->
                                <input type="text" placeholder="Enter Company Name" name="company_name"
                                    autocomplete="off" class="form-control bg-transparent"
                                    value="{{ isset($comp_details->company_name) && !empty($comp_details->company_name) ? $comp_details->company_name : old('company_name') }}"
                                    required />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('company_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <!--end::Name-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Enter Company Web Site" name="company_website"
                                    autocomplete="off" class="form-control bg-transparent"
                                    value="{{ isset($comp_details->company_website) && !empty($comp_details->company_website) ? $comp_details->company_website : old('company_website') }}"
                                    required />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('company_website')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <!--end::Email-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Input-->
                                <textarea class="form-control bg-transparent" name="about_company" data-kt-autosize="true"
                                    placeholder="Write something about company..." required>{{ isset($comp_details->about_company) && !empty($comp_details->about_company) ? $comp_details->about_company : old('about_company') }}</textarea>
                                <!--end::Input-->
                                {{-- <input type="text" placeholder="Enter Company Web Site" name="about_company" autocomplete="off" class="form-control bg-transparent" value="{{ (isset($comp_details->about_company) && !empty($comp_details->about_company)) ? $comp_details->about_company : old('about_company') }}" required/> --}}
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('about_company')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <!--end::Email-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Input-->
                                <textarea class="form-control bg-transparent" name="company_address" data-kt-autosize="true"
                                    placeholder="Enter company address here..." required>{{ isset($comp_details->company_address) && !empty($comp_details->company_address) ? $comp_details->company_address : old('company_address') }}</textarea>
                                <!--end::Input-->
                                {{-- <input type="text" placeholder="Enter Company Web Site" name="about_company" autocomplete="off" class="form-control bg-transparent" value="{{ (isset($comp_details->about_company) && !empty($comp_details->about_company)) ? $comp_details->about_company : old('about_company') }}" required/> --}}
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('company_address')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <!--end::Email-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!--begin::Input group-->
                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Contact Name" name="contact_name" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($comp_details->contact_name) && !empty($comp_details->contact_name) ? $comp_details->contact_name : old('contact_name') }}"
                                required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('contact_name')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Name-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group--->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="email" placeholder="Contact Email" name="contact_email" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($comp_details->contact_email) && !empty($comp_details->contact_email) ? $comp_details->contact_email : old('contact_email') }}"
                                required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('contact_email')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Email-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Input-->
                            <input type="number" name="contact_phone" class="form-control bg-transparent"
                                placeholder="Contact Number"
                                value="{{ isset($comp_details->contact_phone) && !empty($comp_details->contact_phone) ? $comp_details->contact_phone : old('contact_phone') }}"
                                required />
                            <!--end::Input-->
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('contact_phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="col-md-6">
                        <!--begin::Input group-->
                        <div class="fv-row mb-8" id="timezone_div">
                            <select name="timezone" id="timezone" style="cursor: pointer;"
                                class="form-control form-select bg-transparent" required>
                                <option value="">Set Time Zone</option>
                                @foreach ($time_zones as $key => $val)
                                    @if (isset($comp_details->timezone) && $comp_details->timezone == $key)
                                        <option selected value="{{ $key }}">
                                            {{ $val }}
                                        </option>
                                    @else
                                        <option value="{{ $key }}">
                                            {{ $val }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('timezone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-8" id="date_time_format_div">
                            <select name="date_time_format" id="date_time_format" style="cursor: pointer;"
                                class="form-control form-select bg-transparent" required>
                                @foreach ($datetimeformat as $val)
                                    @if (isset($comp_details->date_time_format) && $comp_details->date_time_format == $val)
                                        <option selected value="{{ $val }}">
                                            {{ $val }}
                                        </option>
                                    @else
                                        <option value="{{ $val }}">
                                            {{ $val }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('date_time_format')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="row mb-8">
                            <div class="col-md-6 text-center">
                                <a href="{{ url('/companies') }}" class="btn btn-light" style="width: 100%;">Discard</a>
                            </div>
                            <div class="col-md-6 text-center">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    <span
                                        class="indicator-label">{{ isset($edit_comp_details) && $edit_comp_details == true ? 'Update' : 'Save' }}</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>
                </div>
                <!--end::Scroll-->
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#timezone', ).select2({
                dropdownParent: $('#timezone_div')
                width: "100%"
            });
            $('#date_time_format').select2({
                dropdownParent: $('#date_time_format_div')
                width: "100%"
            });
        });
    </script>
@endsection
