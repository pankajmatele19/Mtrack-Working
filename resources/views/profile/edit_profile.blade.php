<!--begin::Basic info-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" action="{{ url('/myprofile') }}" method="POST" class="form"
            enctype="multipart/form-data">
            @csrf
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group avatar-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline" data-kt-image-input="true"
                            style="background-image: url('assets/media/svg/avatars/blank.svg')">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-125px h-125px"
                                style="background-image: {{ !empty($user->profile_pic) ? 'url(' . $user->profile_pic . ')' : '' }}">
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
                                <input type="file" name="profile_pic" accept=".png, .jpg, .jpeg" />
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
                            @error('profile_pic')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group Name-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row">
                                <input type="text" name="name"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="Full name" value="{{ !empty($user->name) ? $user->name : '' }}" />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('name')
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
                <!--begin::Input group Email-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 fv-row">
                                <input type="text" name="email"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="Enter email" value="{{ !empty($user->email) ? $user->email : '' }}"
                                    required />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('email')
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
                <!--begin::Input group phone-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span>Phone</span>
                        <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
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
                        <input type="tel" name="phone" class="form-control form-control-lg form-control-solid"
                            placeholder="Phone number" value="{{ !empty($user->phone) ? $user->phone : '' }}" />
                        <span class="field_errors" style="color: rgb(230, 33, 33)">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                @if ($user->is_company_super_admin == 1)
                    <!--begin::Input group Role-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span>Role</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="role_id" aria-label="Select a Role" data-control="select2"
                                data-placeholder="Select a Role..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Select a Role...</option>
                                @if (isset($roles))
                                    @foreach ($roles as $key => $val)
                                        @if (isset($role->id) && $val->id == $role->id)
                                            <option selected data-kt-flag="flags/afghanistan.svg"
                                                value="{{ $val->id }}">
                                                {{ $val->title }}</option>
                                        @else
                                            <option data-kt-flag="flags/afghanistan.svg" value="{{ $val->id }}">
                                                {{ $val->title }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                @endif
                <!--begin::Input group Country-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span>Country</span>
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
                                    @if ($val->id == $user->country)
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
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group Language-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Language</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <!--begin::Input-->
                        <select name="language_id" aria-label="Select a Language" data-control="select2"
                            data-placeholder="Select a language..."
                            class="form-select form-select-solid form-select-lg">
                            <option value="">Select a Language...</option>
                            @if (isset($languages))
                                @foreach ($languages as $key => $val)
                                    @if ($val->id == $user->language_id)
                                        <option selected data-kt-flag="flags/afghanistan.svg"
                                            value="{{ $val->id }}">
                                            {{ $val->value }}</option>
                                    @else
                                        <option data-kt-flag="flags/afghanistan.svg" value="{{ $val->id }}">
                                            {{ $val->value }}</option>
                                    @endif
                                @endforeach
                            @endif

                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="button" id="reset_password_btn"
                    class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-2">Reset
                    Password</button>
                <button type="submit" class="btn btn-primary">Save
                    Changes</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
<!--end::Basic info-->
