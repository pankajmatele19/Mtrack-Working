<!-- Ensure jQuery is loaded first -->

<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{ isset($edit_emp_details) && $edit_emp_details == true ? 'Edit Employee' : 'Add New Employee' }}</h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_emp_form" class="form"
            action="{{ isset($edit_emp_details) && $edit_emp_details == true ? url('/employee/edit') . '/' . (isset($val->id) ? $val->id : '') : url('/employee/add_new') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <!--begin::Input group-->
                <div class="col-md-4 mb-7">
                    <div class="row">
                        <div class="col-md-12 mb-7">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Profile</label>
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
                            <div class="image-input image-input-outline image-input-placeholder {{ isset($emp_details->profile_pic) && !empty($emp_details->profile_pic) ? '' : 'image-input-empty' }}"
                                data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: {{ isset($emp_details->profile_pic) && !empty($emp_details->profile_pic) ? 'url(' . $emp_details->profile_pic . ')' : 'none' }};">
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
                                    <input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
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
                                @error('profile_image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
                <div class="col-md-8">
                    <div class="row">
                        @if ($flag == 1)
                            <div class="col-md-12 mb-7" id="myModal">
                                <select name="company_id" id="company" style="cursor: pointer;"
                                    class="form-control form-select bg-transparent" required>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $val)
                                        @if (isset($emp_details->company_id) && $emp_details->company_id == $val->id)
                                            <option selected value="{{ $val->id }}">
                                                {{ $val->company_name }}
                                            </option>
                                        @else
                                            <option value="{{ $val->id }}">
                                                {{ $val->company_name }}
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
                        @else
                            <input type="hidden" name="company_id"
                                value="{{ isset($company_id) ? $company_id : '' }}">
                        @endif
                        <!--begin::Input group-->
                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Name" name="name" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($emp_details->name) && !empty($emp_details->name) ? $emp_details->name : old('name') }}"
                                required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Name-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group--->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="email" placeholder="Enter Email" name="email" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($emp_details->email) && !empty($emp_details->email) ? $emp_details->email : old('email') }}"
                                required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Email-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Input-->
                            <input type="number" name="phone" class="form-control bg-transparent"
                                placeholder="Enter Phone Number"
                                value="{{ isset($emp_details->phone) && !empty($emp_details->phone) ? $emp_details->phone : old('phone') }}"
                                required />
                            <!--end::Input-->
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-md-12 mb-7" id="myModal">
                            <select name="department_id" id="department" style="cursor: pointer;"
                                class="form-control form-select bg-transparent" required>
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ isset($emp_details) && $emp_details->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('department_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>
            </div>
            <hr style="border-top: 1px dashed;">
            @if (isset($settings))
                <h3 class="mb-5">Settings</h3>
                <div class="row">
                    @foreach ($settings as $key => $val)
                        <div class="col-md-6 mb-5">
                            <!--begin::Notice-->
                            <div class="notice d-flex rounded border-primary border border-dashed p-3">
                                <!--begin::Wrapper-->
                                <div class="row">
                                    <!--begin::Content-->
                                    <div
                                        class="{{ in_array('interval', array_keys($val)) ? 'col-md-8' : 'col-md-10' }}">
                                        <div class="fs-7 text-gray-700">
                                            <h6>{{ $val['title'] }}</h6>
                                            <span>{{ $val['description'] }}</span>
                                        </div>
                                    </div>
                                    @if (in_array('interval', array_keys($val)))
                                        <div class="col-md-4 text-end my-auto">
                                            <input type="number" class="form-control bg-transparent"
                                                name="{{ $key }}" id="{{ $key }}"
                                                value="{{ $val['value'] }}">
                                        </div>
                                    @else
                                        <div class="col-md-2 text-end my-auto">
                                            <input type="checkbox" class="form-check-input"
                                                name="{{ $key }}"
                                                {{ isset($val['value']) && $val['value'] == 1 ? 'checked' : '' }} />
                                            {{-- <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                                    <input type="checkbox" name="Checkboxes16" checked="checked">
                                                </label> --}}
                                        </div>
                                    @endif
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                        </div>
                    @endforeach
                </div>
            @endif
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-10">
                <a href="{{ url('/employees') }}" class="btn btn-light me-3">Discard</a>
                <button type="submit" class="btn btn-primary">
                    <span
                        class="indicator-label">{{ isset($edit_emp_details) && $edit_emp_details == true ? 'Update' : 'Save' }}</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#company, #department').select2({
            dropdownParent: $('#myModal'),
            width: "100%"
        });
    });
</script>
