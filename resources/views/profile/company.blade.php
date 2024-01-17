<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Company Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" action="{{ url('/company') }}" method="POST" class="form"
            enctype="multipart/form-data">
            @csrf
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Logo</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline" data-kt-image-input="true"
                            style="background-image: url('assets/media/svg/avatars/blank.svg')">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-300px h-200px"
                                style="background-image: {{ !empty($company->company_logo) ? 'url(' . $company->company_logo . ')' : '' }}">
                            </div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <!--begin::Inputs-->
                                <input type="file" name="company_logo" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
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
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group company_name-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company_name"
                            class="form-control form-control-lg form-control-solid" placeholder="Company name"
                            value="{{ !empty($company->company_name) ? $company->company_name : ($flag == 1 ? 'mTrack' : '') }}" />
                        <span class="field_errors" style="color: rgb(230, 33, 33)">
                            @error('company_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group company_website-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Site</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="company_website"
                            class="form-control form-control-lg form-control-solid" placeholder="Company website"
                            value="{{ !empty($company->company_website) ? $company->company_website : ($flag == 1 ? url('') : '') }}" />
                        <span class="field_errors" style="color: rgb(230, 33, 33)">
                            @error('company_website')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group about company--->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">About Company</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea class="form-control form-control-lg form-control-solid" name="about_company" id="about_company"
                            data-kt-autosize="true" placeholder="Write something about company..." required>{{ isset($company->about_company) && !empty($company->about_company) ? $company->about_company : old('about_company') }}</textarea>
                    </div>
                    <!--end::Col-->
                    <span class="field_errors" style="color: rgb(230, 33, 33)">
                        @error('about_company')
                            {{ $message }}
                        @enderror
                    </span>
                    <!--end::Email-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group Country-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span class="required">Country</span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select name="country" aria-label="Select a Country" data-control="select2"
                            data-placeholder="Select a country..."
                            class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">Select a Country...</option>
                            @if (isset($countries))
                                @foreach ($countries as $key => $val)
                                    @if (isset($company->country) && !empty($company->country) && $val->id == $company->country)
                                        <option selected data-kt-flag="flags/afghanistan.svg"
                                            value="{{ $val->id }}">
                                            {{ $val->name }}</option>
                                    @else
                                        <option data-kt-flag="flags/afghanistan.svg" value="{{ $val->id }}">
                                            {{ $val->name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <span class="field_errors" style="color: rgb(230, 33, 33)">
                            @error('country')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span class="required">Timezone</span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="Local Timezone">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select name="timezone" id="timezone" aria-label="Select a Timezone" data-control="select2"
                            data-placeholder="Select a timezone..."
                            class="form-select form-select-solid form-select-lg fw-semibold" required>
                            <option value="">Set Time Zone</option>
                            @foreach ($timezones as $key => $val)
                                @if (isset($company->timezone) && $company->timezone == $key)
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
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span>Date Time Format</span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="Date and Time Format">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select name="date_time_format" id="date_time_format"
                            aria-label="Select a Date & Time Format" data-control="select2"
                            data-placeholder="Select a date time formate..."
                            class="form-select form-select-solid form-select-lg fw-semibold">
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
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group contact_name-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Contact Name</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row">
                                <input type="text" name="contact_name"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="Contact name"
                                    value="{{ !empty($company->contact_name) ? $company->contact_name : '' }}" />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('contact_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group contact_email-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Contact Email</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row">
                                <input type="text" name="contact_email"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="Contact email"
                                    value="{{ !empty($company->contact_email) ? $company->contact_email : '' }}" />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('contact_email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group contact_phone-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row">
                                <input type="text" name="contact_phone"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="Contact email"
                                    value="{{ !empty($company->contact_phone) ? $company->contact_phone : '' }}" />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('contact_phone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group company address--->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Address</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea class="form-control form-control-lg form-control-solid" name="company_address" data-kt-autosize="true"
                            placeholder="Enter company address here..." required>{{ isset($company->company_address) && !empty($company->company_address) ? $company->company_address : old('company_address') }}</textarea>
                    </div>
                    <!--end::Col-->
                    <span class="field_errors" style="color: rgb(230, 33, 33)">
                        @error('company_address')
                            {{ $message }}
                        @enderror
                    </span>
                    <!--end::Email-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                    Changes</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
