<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{ isset($edit_category_details) && $edit_category_details == true ? 'Edit Category' : 'Add New Category' }}
        </h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_category_form" class="form"
            action="{{ isset($edit_category_details) && $edit_category_details == true ? url('/applications_categories/edit/' . (isset($category_details->id) ? $category_details->id : '')) : url('/applications_categories/add') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <!--begin::Input group-->
                <div class="fv-row mb-8">
                    <!--begin::Name-->
                    <input type="text" placeholder="Enter category Name" name="category_name" autocomplete="off"
                        class="form-control bg-transparent"
                        value="{{ isset($category_details->category_name) && !empty($category_details->category_name) ? $category_details->category_name : old('category_name') }}"
                        required />
                    <span class="field_errors" style="color: rgb(230, 33, 33)">
                        @error('category_name')
                            {{ $message }}
                        @enderror
                    </span>
                    <!--end::Name-->
                </div>
                <!--end::Input group-->
                <!-- Add the dropdown for company_id -->
                @if ($flag)
                    <div class="fv-row mb-8">
                        <label for="company_id" class="form-label">Select Company</label>
                        <select name="company_id" id="company_id" class="form-control" required>
                            {{-- @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ isset($category_details->company_id) && $category_details->company_id == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach --}}
                        </select>
                        <span class="field_errors" style="color: rgb(230, 33, 33)">
                            @error('company_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                @else
                    <!-- Add a hidden input for company_id -->
                    <input type="hidden" name="company_id" value="{{ $user->company_id }}">
                @endif



            </div>
            <!--begin::Actions-->
            <div class="row mb-8">
                <div class="col-md-6 text-center">
                    <a href="{{ url('/companies') }}" class="btn btn-light" style="width: 100%;">Discard</a>
                </div>
                <div class="col-md-6 text-center">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <span
                            class="indicator-label">{{ isset($edit_category_details) && $edit_category_details == true ? 'Update' : 'Save' }}</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
            <!--end::Actions-->
            <!--end::Scroll-->
        </form>
        <!--end::Form-->
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#timezone').select2({
            width: "100%"
        });
        $('#date_time_format').select2({
            width: "100%"
        });
    });
</script>
