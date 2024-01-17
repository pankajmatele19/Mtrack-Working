{{-- <a class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click"
    data-kt-menu-placement="bottom-end">Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
    data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="{{ isset($routeName) ? url('/superadmin/application/edit') . '/' . (isset($val->id) ? $val->id : '') : url('/application/edit') . '/' . (isset($val->id) ? $val->id : '') }}"
            class="menu-link px-3">Edit</a>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="" data-id="{{ $val->id }}" class="delete menu-link px-3"
            data-kt-datatable-table-filter="delete_row">Delete</a>
    </div>
    <!--end::Menu item-->
</div> --}}
<!--end::Menu-->
<div class="dropdown">
    <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" onclick="toggleDropdown()">
        Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
    </button>

    <div id="dropdownMenu" class="dropdown-menu fw-semibold fs-7 w-125px py-4">
        <div class="menu-item px-3">
            <a href="" class="menu-link px-3 edit_application" data-toggle="modal"
                data-target="#editApplicationModal" data-application-id="{{ isset($val->id) ? $val->id : '' }}">
                Edit
            </a>
        </div>
        <div class="menu-item px-3">
            <a href="javascript:void(0);" data-id="{{ $val->id }}" class="delete menu-link px-3"
                data-kt-datatable-table-filter="delete_row"
                onclick="softDeleteCompanyApp({{ $val->id }})">Delete</a>
        </div>
    </div>
</div>

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('show');
    }

    function deleteItem() {
        // Add your delete logic here
        alert('Delete action');
    }

    // Close the dropdown when clicking outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.btn')) {
            var dropdowns = document.getElementsByClassName("dropdown-menu");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
