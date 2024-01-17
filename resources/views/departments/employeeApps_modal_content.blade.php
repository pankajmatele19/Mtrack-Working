<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{ isset($edit_employee_details) && $edit_employee_details == true ? 'Edit Employees App' : 'Add New Employees App' }}
        </h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_app_form" class="form"
            action="{{ isset($edit_employee_details) && $edit_employee_details == true ? url('/departments_employees/edit') . '/' . (isset($employee_details->id) ? $employee_details->id : '') : url('/departments_employees/add') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        @if ($flag == 1)
                            <div class="col-md-12 mb-7" id="myModal">
                                <select name="company_id" id="company_id" class="form-select bg-transparent">
                                    <option value="" selected disabled>Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ isset($employee_details) && $employee_details->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="field_errors" style="color: rgb(230, 33, 33)">
                                    @error('company_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        @endif
                        @if ($flag != 1)
                            <div class="fv-row mb-8" id="myModal">
                                <input type="hidden" name="company_id" value="{{ $userCompanyId }}">
                            </div>
                        @endif

                        <!-- Department dropdown -->
                        <div class="fv-row mb-8" id="myModal">
                            <select name="department_id[]" id="department_id" class="form-select bg-transparent"
                                multiple="multiple">
                                {{-- <option value="" selected disabled>Select Department</option> --}}
                                {{-- Check if in edit mode --}}
                                @if (isset($edit_app_details) && $edit_app_details == true)
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ isset($app_details) && $app_details->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                @else
                                    {{-- Options will be dynamically populated via JavaScript --}}
                                @endif
                            </select>
                            <!-- Add error message display if needed -->
                        </div>

                        <div class="fv-row mb-8" id="myModal">
                            <select id="employee_id" name="employee_id[]" class="form-select bg-transparent"
                                data-edit-employee-id="{{ isset($employee_details) ? $employee_details->employee_id : '' }}"
                                multiple="multiple">
                                {{-- Check if in edit mode --}}
                                @if (isset($edit_employee_details) && $edit_employee_details == true)
                                    @foreach ($employees as $employee)
                                        @if (isset($employee_details) && $employee_details->company_id == $employee->company_id)
                                            <option value="{{ $employee->id }}"
                                                {{ isset($employee_details) && $employee_details->employee_id == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->employee_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                @endif
                            </select>

                            <!-- Add error message display if needed -->
                        </div>


                        {{-- categpries --}}
                        <div class="fv-row mb-8" id="myModal">
                            <!--begin::Category-->
                            <select name="category_id[]" id="category_id" class="form-select bg-transparent"
                                multiple="multiple">
                                {{-- <option value="" selected disabled>Select Category</option> --}}
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


                        <div class="fv-row mb-8" id="myModal">
                            <select id="app_id" name="app_id[]" class="form-select bg-transparent"
                                multiple="multiple">
                                {{-- Check if in edit mode --}}
                                @if (isset($edit_employee_details) && $edit_employee_details == true)
                                    @foreach ($applications as $application)
                                        @if (isset($employee_details) && $employee_details->company_id == $application->company_id)
                                            <option value="{{ $application->id }}"
                                                {{ isset($employee_details) && $employee_details->app_id == $application->id ? 'selected' : '' }}>
                                                {{ $application->app_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                    {{-- Options will be dynamically populated via JavaScript --}}
                                @endif
                            </select>
                            <!-- Add error message display if needed -->
                        </div>

                        {{-- <!-- Status dropdown -->
                        <div class="fv-row mb-8" id="myModal">
                            <select name="status" id="status" class="form-select bg-transparent">
                                <option value="" selected disabled>Select Status</option>
                                <option value="1"
                                    {{ isset($employee_details) && $employee_details->status == 1 ? 'selected' : '' }}>
                                    Non-Productive
                                </option>
                                <option value="0"
                                    {{ isset($employee_details) && $employee_details->status == 0 ? 'selected' : '' }}>
                                    Productive
                                </option>
                            </select>
                            <!-- Add error message display if needed -->
                        </div> --}}

                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <!--begin::Actions-->
            <div class="text-center pt-10">
                <a href="{{ url('/applications') }}" class="btn btn-light me-3">Discard</a>
                <button type="submit" class="btn btn-primary">
                    <span
                        class="indicator-label">{{ isset($edit_employee_details) && $edit_employee_details == true ? 'Update' : 'Save' }}</span>
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
        $('#category_id').select2({
            placeholder: "Select a Category",
            dropdownParent: $('#myModal'),
            width: "100%",
            allowClear: true, // Add this line to allow clearing the selection
        }).on('select2:open', function(e) {
            // Add "Select All" option
            var selectAllOption = $('<option>', {
                value: 'all',
                text: 'Select All',
                class: 'select-all-option'
            });
            if (!$('#category_id option[value="all"]').length) {
                $('#category_id').append(selectAllOption);
            }
            $('.select-all-option').on('mousedown', function(e) {
                e.preventDefault();
                $(this).prop('selected', !$(this).prop('selected')).trigger('change');
            });
        });

        $('#app_id').select2({
            placeholder: "Select an Application",
            dropdownParent: $('#myModal'),
            width: "100%",
            allowClear: true, // Add this line to allow clearing the selection
        }).on('select2:open', function(e) {
            // Add "Select All" option
            var selectAllOption = $('<option>', {
                value: 'all',
                text: 'Select All',
                class: 'select-all-option'
            });
            if (!$('#app_id option[value="all"]').length) {
                $('#app_id').append(selectAllOption);
            }
            $('.select-all-option').on('mousedown', function(e) {
                e.preventDefault();
                $(this).prop('selected', !$(this).prop('selected')).trigger('change');
            });
        });

        $('#department_id').select2({
            placeholder: "Select a Department",
            dropdownParent: $('#myModal'),
            width: "100%",
            allowClear: true, // Add this line to allow clearing the selection
        }).on('select2:open', function(e) {
            // Add "Select All" option
            var selectAllOption = $('<option>', {
                value: 'all',
                text: 'Select All',
                class: 'select-all-option'
            });
            if (!$('#department_id option[value="all"]').length) {
                $('#department_id').append(selectAllOption);
            }
            $('.select-all-option').on('mousedown', function(e) {
                e.preventDefault();
                $(this).prop('selected', !$(this).prop('selected')).trigger('change');
            });
        });

        $('#employee_id').select2({
            placeholder: "Select a Employee",
            dropdownParent: $('#myModal'),
            width: "100%",
            allowClear: true, // Add this line to allow clearing the selection
        }).on('select2:open', function(e) {
            // Add "Select All" option
            var selectAllOption = $('<option>', {
                value: 'all',
                text: 'Select All',
                class: 'select-all-option'
            });
            if (!$('#employee_id option[value="all"]').length) {
                $('#employee_id').append(selectAllOption);
            }
            $('.select-all-option').on('mousedown', function(e) {
                e.preventDefault();
                $(this).prop('selected', !$(this).prop('selected')).trigger('change');
            });
        });

        $('#status').select2({
            dropdownParent: $('#myModal'),
            width: "100%"
        });
        $('#company_id').select2({
            dropdownParent: $('#myModal'),
            width: "100%"
        });
    });
</script>
{{-- <script>
    $(document).ready(function() {
        $('#company_id').on('change', function() {
            var companyId = $(this).val();
            // Make an AJAX request to fetch applications, categories, and departments based on the selected company
            $.ajax({
                type: 'GET',
                url: '/departments_employees/get-employees-by-company/' + companyId,
                success: function(data) {
                    // Update the applications dropdown
                    var appsDropdown = $('#app_id');
                    appsDropdown.empty();
                    appsDropdown.append(
                        '<option value="" selected disabled>Select Application</option>'
                    );
                    $.each(data.applications, function(id, app) {
                        var newOption = new Option(app.app_name, app.id, false,
                            false);
                        appsDropdown.append(newOption).trigger('change');
                    });

                    // Update the employees dropdown
                    var employeesDropdown = $('#employee_id');
                    employeesDropdown.empty();
                    employeesDropdown.append(
                        '<option value="" selected disabled>Select Employee</option>');
                    $.each(data.employees, function(id, emp) {
                        var newOption = new Option(emp.name, emp.id, false, false);
                        employeesDropdown.append(newOption).trigger('change');
                    });

                    // Check if it's an edit operation
                    var editEmployeeId = $('#employee_id').data('edit-employee-id');
                    console.log('Edit Employee ID:', editEmployeeId);

                    if (editEmployeeId) {
                        // Set the selected value for the employee dropdown
                        employeesDropdown.val(editEmployeeId).trigger('change');
                    }
                }
            });
        });
    });
</script> --}}
<script>
    $(document).ready(function() {
        // Check if the company dropdown is present
        if ($('#company_id').is(":visible")) {
            // If super admin, use the selected company from the dropdown
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                fetchEmployeesAndApplications(companyId);
            });
        } else {
            // If normal user, use the user's company ID directly
            fetchEmployeesAndApplications('{{ $userCompanyId }}');
        }

        function fetchEmployeesAndApplications(companyId) {
            $.ajax({
                type: 'GET',
                url: '/departments_employees/get-employees-by-company/' + companyId,
                success: function(data) {
                    console.log('Data received:', data); // Log the data received

                    // Update the applications dropdown
                    var appsDropdown = $('#app_id');
                    appsDropdown.empty();
                    $.each(data.applications, function(id, app) {
                        var newOption = new Option(app.app_name, app.id, false, false);
                        appsDropdown.append(newOption).trigger('change');
                    });
                    // Update the departments dropdown
                    var departmentsDropdown = $('#department_id');
                    departmentsDropdown.empty();
                    $.each(data.departments, function(id, department) {
                        departmentsDropdown.append('<option value="' + department
                            .id + '">' + department.department_name +
                            '</option>');
                    });

                    // Update the categories dropdown
                    var categoriesDropdown = $('#category_id');
                    categoriesDropdown.empty();
                    $.each(data.categories, function(id, category) {
                        categoriesDropdown.append('<option value="' + category.id + '">' +
                            category.category_name + '</option>');
                    });

                    // Update the employees dropdown
                    var employeesDropdown = $('#employee_id');
                    employeesDropdown.empty();
                    $.each(data.employees, function(id, emp) {
                        var newOption = new Option(emp.name, emp.id, false, false);
                        employeesDropdown.append(newOption).trigger('change');
                    });

                    // Check if it's an edit operation
                    var editEmployeeId = $('#employee_id').data('edit-employee-id');
                    console.log('Edit Employee ID:', editEmployeeId);

                    if (editEmployeeId) {
                        // Set the selected value for the employee dropdown
                        employeesDropdown.val(editEmployeeId).trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
