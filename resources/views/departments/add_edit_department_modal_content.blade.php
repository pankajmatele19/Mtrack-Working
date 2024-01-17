<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{ isset($edit_dept_details) && $edit_dept_details == true ? 'Edit Department' : 'Add New Department' }}
        </h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_app_form" class="form"
            action="{{ isset($edit_dept_details) && $edit_dept_details == true ? url('/department/edit/') . (isset($dept_details->id) ? $dept_details->id : '') : url('/department/add') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Name" name="name" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($dept_details->department_name) && !empty($dept_details->department_name) ? $dept_details->department_name : old('department_name') }}"
                                required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Name-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-8">
                            <!--begin::Description-->
                            <textarea class="form-control bg-transparent" name="description" data-kt-element="input" placeholder="Enter Description"
                                required>{{ isset($dept_details->department_desc) && !empty($dept_details->department_desc) ? $dept_details->department_desc : old('description') }}</textarea>
                            <!--end::Description-->
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!--end::Input group-->
                        @if ($flag == 1)
                            <div class="col-md-12 mb-7" id="myModal">
                                <select name="company_id" id="company" style="cursor: pointer;"
                                    class="form-control form-select bg-transparent" {{ !$flag ? 'disabled' : '' }}
                                    required>
                                    <option value="{{ $company_id }}" selected>{{ $company_name }}</option>
                                    @foreach ($companies as $company)
                                        @if (isset($dept_details->company_id) && $dept_details->company_id == $company->id)
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
                        @else
                            <input type="hidden" name="company_id" value="{{ $company_id }}">
                        @endif
                        <!--end::Input group-->
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <!--begin::Actions-->
            <div class="text-center pt-10">
                <a href="{{ url('/applications') }}" class="btn btn-light me-3">Discard</a>
                <button type="submit" class="btn btn-primary">
                    <span
                        class="indicator-label">{{ isset($edit_dept_details) && $edit_dept_details == true ? 'Update' : 'Save' }}</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#company').select2({
            dropdownParent: $('#myModal'),
            width: "100%"
        });
    });
</script>
