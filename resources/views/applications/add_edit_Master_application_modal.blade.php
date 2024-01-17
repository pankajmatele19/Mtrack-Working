<div class="card">
    <div class="card-header mx-auto pt-6">
        <h2>{{ isset($edit_app_details) && $edit_app_details == true ? 'Edit Application' : 'Add New Application' }}
        </h2>
    </div>
    <div class="card-body">
        <!--begin::Form-->
        <form id="add_edit_app_form" class="form"
            action="{{ isset($edit_app_details) && $edit_app_details == true ? url('/master_application/edit') . '/' . (isset($app_details->id) ? $app_details->id : '') : url('/master_application/add') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Scroll-->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="fv-row mb-8">
                            <!--begin::Name-->
                            <input type="text" placeholder="Enter Name" name="app_name" autocomplete="off"
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
                        <div class="fv-row mb-8" id="myModal">
                            <!--begin::Category-->
                            <select name="category_id" id="category_id" class="form-select bg-transparent">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($app_details) && $app_details->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('category_id')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!--end::Category-->
                        </div>

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
    });
</script>
