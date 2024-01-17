<!--begin::Notice-->
<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
    <!--begin::Icon-->
    <i class="ki-duotone ki-information fs-2tx text-warning me-4">
        <span class="path1"></span>
        <span class="path2"></span>
        <span class="path3"></span>
    </i>
    <!--end::Icon-->
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-grow-1">
        <!--begin::Content-->
        <div class="fw-semibold">
            <div class="fs-6 text-gray-700">
                <strong class="me-1">Warning!</strong>By
                editing the permission name, you might break the
                system permissions functionality. Please ensure
                you're absolutely certain before proceeding.
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Notice-->
<!--begin::Form-->
<form id="kt_modal_update_permission_form" class="form"
    action="{{ isset($routeName) ? url('/superadmin/permissions') : url('/permissions') }}" method="POST">
    @csrf
    <input type="hidden" name="modal_id" value="#kt_modal_update_permission">
    <input type="hidden" name="permission_id" value="{{ isset($permission->id) ? $permission->id : '' }}">
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Permission Name</span>
            <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true"
                data-bs-content="Permission names is required to be unique.">
                <i class="ki-duotone ki-information fs-7">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
            </span>
        </label>
        <!--end::Label-->
        <!--begin::Input-->
        <input class="form-control form-control-solid" placeholder="Enter a permission name" name="title"
            value="{{ isset($permission->title) ? $permission->title : '' }}" required />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Type</span>
            <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true"
                data-bs-content="Permission type unique for permission.">
                <i class="ki-duotone ki-information fs-7">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
            </span>
        </label>
        <!--end::Label-->
        <!--begin::Input-->
        <input class="form-control form-control-solid"
            placeholder="Enter a permission type (e.g create, read, update, delete etc.)" name="type"
            value="{{ isset($permission->type) ? $permission->type : '' }}" required />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Checkbox-->
        <label class="form-check form-check-custom form-check-solid me-9">
            <input class="form-check-input" type="checkbox" value="1" name="for_superadmin"
                @if (isset($permission->for_superadmin) && $permission->for_superadmin == 1) checked @endif id="kt_permissions_core" />
            <span class="form-check-label" for="kt_permissions_core">Check if this is only for
                Super
                admin</span>
        </label>
        <!--end::Checkbox-->
    </div>
    <!--end::Input group-->
    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="update_permission_discard btn btn-light me-3"
            data-kt-permissions-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary">{{-- data-kt-permissions-modal-action="submit" --}}
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
<!--end::Form-->
