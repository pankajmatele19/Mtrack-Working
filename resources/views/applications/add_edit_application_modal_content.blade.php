<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{ isset($edit_app_details) && $edit_app_details == true ? 'Edit Application' : 'Add New Application' }}
        </h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_app_form" class="form"
            action="{{ isset($edit_app_details) && $edit_app_details == true ? url('/application/edit') . '/' . (isset($app_details->id) ? $app_details->id : '') : url('/application/add') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <!--end::Input group-->
                        @if ($flag == 1)
                            <div class="col-md-12 mb-7" id="myModal">
                                <select name="company_id" id="company_id" style="cursor: pointer;"
                                    class="form-control form-select bg-transparent" {{ !$flag ? 'disabled' : '' }}
                                    required>
                                    <option value="{{ $company_id }}" selected>{{ $company_name }}</option>
                                    @foreach ($companies as $company)
                                        @if (isset($app_details->company_id) && $app_details->company_id == $company->id)
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

                        <div class="fv-row mb-8" id="myModal">
                            <!--begin::Category-->
                            <select name="category_id" id="category_id" class="form-select bg-transparent">
                                <option value="" selected disabled>Select Category</option>
                                @if (isset($edit_app_details) && $edit_app_details == true)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            {{ isset($app_details) && $app_details->category_id == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                            {{ $category->category_id }}
                                        </option>
                                    @endforeach
                                @else
                                    {{-- Options will be dynamically populated via JavaScript --}}
                                @endif
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('category_id')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Category-->
                        </div>

                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Name" name="name" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($app_details->app_name) && !empty($app_details->app_name) ? $app_details->app_name : old('app_name') }}"
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
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Description" name="description" autocomplete="off"
                                class="form-control bg-transparent"
                                value="{{ isset($app_details->description) && !empty($app_details->description) ? $app_details->description : old('description') }}"
                                required />
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Name-->
                        </div>
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
                        class="indicator-label">{{ isset($edit_app_details) && $edit_app_details == true ? 'Update' : 'Save' }}</span>
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
<script>
    $(document).ready(function() {
        // Initialize Select2 for the category dropdown
        $('#category_id').select2({
            dropdownParent: $('#myModal'),
            width: '100%'
        });
        $('#company_id').select2({
            dropdownParent: $('#myModal'),
            width: '100%'
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Check if the company dropdown is present
        if ($('#company_id').is(":visible")) {
            // If super admin, use the selected company from the dropdown
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                fetchCategories(companyId);
            });
        } else {
            // If normal user, use the user's company ID directly
            fetchCategories('{{ $company_id }}');
        }

        function fetchCategories(companyId) {
            $.ajax({
                type: 'GET',
                url: '/categories/get-categories/' + companyId, // Adjust the URL based on your route
                success: function(data) {
                    // Update the categories dropdown
                    var categoriesDropdown = $('#category_id');
                    categoriesDropdown.empty();
                    categoriesDropdown.append(
                        '<option value="" selected disabled>Select Category</option>');
                    $.each(data.categories, function(id, category) {
                        categoriesDropdown.append('<option value="' + category.id + '">' +
                            category.category_name + '</option>');
                    });
                }
            });
        }
    });
</script>
