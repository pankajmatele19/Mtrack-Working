@extends('users.users')
@section('breadcrumb')
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-400 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted"><a href=""
            class="text-muted text-hover-primary">{{ isset($edit_user_details) && $edit_user_details == true ? 'Edit User' : 'Invite User' }}</a>
    </li>
    <!--end::Item-->
@endsection
@section('action_btns_toolbar')
    <a href="{{ isset($routeName) ? url('/superadmin/users') : url('/users') }}"
        class="btn btn-sm fw-bold btn-primary">Back</a>
@endsection
@section('user_page_content')
    <div class="card">
        <div class="card-header mx-auto pt-6">
            <h2>{{ isset($edit_user_details) && $edit_user_details == true ? 'Edit User' : 'Invite User' }}</h2>
        </div>
        <div class="card-body">
            <!--begin::Form-->
            <form id="add_edit_user_form" class="form" action="" method="POST" enctype="multipart/form-data">
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
                                <div class="image-input image-input-outline image-input-placeholder {{ isset($user_details->profile_pic) && !empty($user_details->profile_pic) ? '' : 'image-input-empty' }}"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: {{ isset($user_details->profile_pic) && !empty($user_details->profile_pic) ? 'url(' . $user_details->profile_pic . ')' : 'none' }};">
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
                                        <input type="file" name="profile_pic" accept=".png, .jpg, .jpeg" />
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
                                    @error('profile_pic')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="col-md-8">
                        <div class="row">
                            @if ($flag == 1 && !isset($routeName))
                                <div class="col-md-6 mb-8">
                                    <select name="company_id" id="company" style="cursor: pointer;"
                                        class="form-control form-select bg-transparent" required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $val)
                                            @if (isset($user_details->company_id) && $user_details->company_id == $val->id)
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
                                <input type="hidden" name="company_id" value="{{ isset($company_id) ? $company_id : 0 }}">
                            @endif
                            <div class="col-md-6 mb-8">
                                <select name="role_id" id="role_id" style="cursor: pointer;"
                                    class="form-control form-select bg-transparent">
                                    <option value="">Select Role</option>
                                    @if (isset($roles))
                                        @foreach ($roles as $val)
                                            @if (isset($user_details->company_id) && $user_details->company_id == $val->company_id)
                                                @if (isset($user_details->role_id) && $user_details->role_id == $val->id)
                                                    <option selected value="{{ $val->id }}">
                                                        {{ $val->title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->title }}
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('role_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-8">
                                <!--begin::Name-->
                                <input type="text" placeholder="Enter Name" name="name" autocomplete="off"
                                    class="form-control bg-transparent"
                                    value="{{ isset($user_details->name) && !empty($user_details->name) ? $user_details->name : old('name') }}"
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
                                    value="{{ isset($user_details->email) && !empty($user_details->email) ? $user_details->email : old('email') }}"
                                    required />
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <!--end::Email-->
                            </div>
                            <!--end::Input group-->
                            @if (isset($edit_user_details) && $edit_user_details == false)
                                <!--begin::Input group--->
                                <div class="fv-row mb-8">
                                    <!--begin::Input-->
                                    <textarea class="form-control bg-transparent" name="invite_message" data-kt-element="input"
                                        placeholder="Write invitation message here..." required>{{ isset($comp_details->invite_message) && !empty($comp_details->invite_message) ? $comp_details->invite_message : old('invite_message') }}</textarea>
                                    <!--end::Input-->
                                    {{-- <input type="text" placeholder="Enter Company Web Site" name="about_company" autocomplete="off" class="form-control bg-transparent" value="{{ (isset($comp_details->about_company) && !empty($comp_details->about_company)) ? $comp_details->about_company : old('about_company') }}" required/> --}}
                                    <span class="field_errors" style="color: rgb(230, 33, 33)">
                                        @error('invite_message')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                    <!--end::Email-->
                                </div>
                                <!--end::Input group-->
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="text-center pt-10">
                    <a href="{{ isset($routeName) ? url('/superadmin/users') : url('/users') }}"
                        class="btn btn-light me-3">Discard</a>
                    <button type="submit" class="btn btn-primary me-2">
                        <span
                            class="indicator-label">{{ isset($edit_user_details) && $edit_user_details == true ? 'Update' : 'Invite' }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    @if (isset($edit_user_details) && $edit_user_details == true)
                        <button type="button" id="reset_password_btn"
                            class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary">Reset
                            Password</button>
                    @endif
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#company').select2({
                width: "100%"
            });
            $('#role_id').select2({
                width: "100%"
            });

            $(document).on('click', '#reset_password_btn', function(e) {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you want to reset password",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, reset!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function(result) {
                    if (result.value) {
                        $('#add_edit_user_form').append(
                            '<input type="hidden" name="reset_password" value="reset_password">'
                        );
                        $('#add_edit_user_form').submit();
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: recordTitle + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            });

            $(document).on('change', '#company', function(e) {
                e.preventDefault();

                var company_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "",
                    data: {
                        company_id: company_id
                    },
                    success: function(response) {
                        $('#role_id')
                            .find('option')
                            .remove()
                            .end()
                            .append(response);
                    }
                });

            });
        });
    </script>
@endsection
