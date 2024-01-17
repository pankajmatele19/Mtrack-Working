<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('assets/') }}";
</script>
<script>
    var csrf_token = "{{ csrf_token() }}";
    var table_name = "{{ isset($table_name) ? $table_name : 'unknown' }}";
    @if (isset($table_name) && $table_name == 'companies')
        var columnDefs = [{
                orderable: false,
                targets: 0
            }, // Disable ordering on column 0 (checkbox)
            {
                orderable: false,
                targets: 6
            }, // Disable ordering on column 6 (actions)
        ]
    @else
        var action_col = 6;
        @if (isset($flag) && $flag != 1)
            action_col = 5;
        @endif
        var columnDefs = [{
                orderable: false,
                targets: 0
            }, // Disable ordering on column 0 (checkbox)
            {
                orderable: false,
                targets: action_col
            },
        ]
    @endif
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
{{-- customer --}}
<script src="{{ asset('assets/js/custom/apps/customers/list/export.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/customers/list/list.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/customers/add.js') }}"></script>

<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
<!--end::Custom Javascript-->




<script>
    $(document).ready(function() {
        $(document).on('click', '.view_employee', function(e) {
            e.preventDefault();
            var emp_id = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: "/employee/edit/" + emp_id,
                data: {
                    'page': "view_employee"
                },
                success: function(response) {
                    $('#kt_modal_view_employee_scroll').html("");
                    $('#kt_modal_view_employee_scroll').html(response);
                    $('#kt_modal_view_employee').modal('show');
                }
            });
        });

        $(document).on('click', '#kt_modal_close_view_employee', function() {
            $('#kt_modal_view_employee').modal('hide');
        });

        $(document).on('click', '.view_company', function(e) {
            e.preventDefault();
            var comp_id = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: "/company/edit/" + comp_id,
                data: {
                    'page': "view_company"
                },
                success: function(response) {
                    $('#kt_modal_view_company_scroll').html("");
                    $('#kt_modal_view_company_scroll').html(response);
                    $('#kt_modal_view_company').modal('show');
                }
            });
        });

        $(document).on('click', '#kt_modal_close_view_company', function() {
            $('#kt_modal_view_company').modal('hide');
        });

        $(document).on('click', '.view_department', function(e) {
            e.preventDefault();
            var dept_id = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: "/department/edit/" + dept_id,
                data: {
                    'page': "view_department"
                },
                success: function(response) {
                    $('#kt_modal_view_department_scroll').html("");
                    $('#kt_modal_view_department_scroll').html(response);
                    $('#kt_modal_view_department').modal('show');
                }
            });
        });

        $(document).on('click', '#kt_modal_close_view_department', function() {
            $('#kt_modal_view_department').modal('hide');
        });

        $(document).on('click', '.view_user', function(e) {
            e.preventDefault();
            var comp_id = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: "/user/edit/" + comp_id,
                data: {
                    'page': "view_user"
                },
                success: function(response) {
                    $('#kt_modal_view_user_scroll').html("");
                    $('#kt_modal_view_user_scroll').html(response);
                    $('#kt_modal_view_user').modal('show');
                }
            });
        });

        $(document).on('click', '#kt_modal_close_view_user', function() {
            $('#kt_modal_view_user').modal('hide');
        });

        $(document).on('change', '#kt_roles_select_all', function(e) {
            e.preventDefault();
            // Apply check state to all checkboxes
            $('.permission').each((c, i) => {
                // $(this).prop('checked',true);
                $('input[name=' + i.name + ']').attr('checked', true);
            });
        });

        @if (session()->has('role_id'))
            var role_id = "{{ session()->get('role_id') }}";
            var element = $(".edit_role_btn").find("[data-id='" + role_id + "']");
            view_modal(element);
        @endif

        function view_modal(edit_role_btn) {

            @if (session()->has('role_id'))
                var role_id = "{{ session()->get('role_id') }}";
            @else
                var role_id = edit_role_btn.attr('data-id');
            @endif

            $.ajax({
                type: "GET",
                url: "{{ isset($routeName) ? '/superadmin/roles' : '/roles' }}",
                data: {
                    role_id: role_id
                },
                success: function(response) {
                    $('#kt_modal_update_role_body').html("");
                    $('#kt_modal_update_role_body').html(response);
                    $('#kt_modal_update_role').modal('show');
                }
            });
        }

        $(document).on('click', '.edit_role_btn', function(e) {
            e.preventDefault();
            view_modal($(this));

        });

        $(document).on('click', '.close_btn', function() {
            var modal_id = $(this).attr('modal_id');

            $('#' + modal_id).modal('hide');
        });

        $(document).on('click', '.edit_permission_btn', function(e) {
            e.preventDefault();
            var permission_id = $(this).attr('edit_permission_id');
            $.ajax({
                type: "GET",
                url: "{{ isset($routeName) ? '/superadmin/permission/edit/' : '/permission/edit/' }}" +
                    permission_id,
                data: {
                    page: "edit_permission_form"
                },
                success: function(response) {
                    $('#edit_permision_form_div').html("");
                    $('#edit_permision_form_div').html(response);
                    $('#kt_modal_update_permission').modal('show');
                }
            });
        });

        // const table = $('#kt_datatable_table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     buttons: [{
        //         extend: 'pdf',
        //         split: ['csv', 'excel'],
        //     }],
        //     dom: 'Bfrtilp',
        //     aaSorting: [],
        //     ajax: {
        //         url: "",
        //         data: function(data) {
        //             data.customParam = 'companies_table'; // Add your extra parameter(s) here
        //         }
        //     },
        //     columns: [{
        //             data: 'id',
        //             name: 'id'
        //         },
        //         {
        //             data: 'company_name',
        //             name: 'company_name'
        //         },
        //         {
        //             data: 'company_website',
        //             name: 'company_website'
        //         },
        //         {
        //             data: 'employees_count',
        //             name: 'employees_count'
        //         },
        //         {
        //             data: 'contact_email',
        //             name: 'contact_email'
        //         },
        //         {
        //             data: 'created_at',
        //             name: 'created_at'
        //         },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             orderable: false,
        //             searchable: false
        //         }
        //     ],
        //     columnDefs: [{
        //         targets: [0], // Index of the column you want to hide (starts from 0)
        //         visible: false // Set this to true to show the column initially
        //     }],
        //     // Add the "createdRow" callback to customize the action column rendering
        //     createdRow: function(row, data, dataIndex) {
        //         var actionCell = $('td', row).eq(-1);
        //         actionCell.html('<a data-candidate-id="' + data.id +
        //             '" class="delete btn btn-icon btn-bg-light btn-active-color-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Link"><span class="svg-icon svg-icon-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" /><path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" /><path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" /></svg> </span></a>'
        //         );
        //     }
        // });

        // table.buttons().container().appendTo('#export-buttons');

        // $('#search').on('keyup', function() {
        //     table.search(this.value).draw();
        // });
    });
</script>
@if ($errors->any())
    <script>
        Swal.fire({
            text: "Sorry, looks like there are some errors detected, please try again.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
@endif

@if (session()->has('modal_id'))
    <script>
        var modal_id = "{{ session()->get('modal_id') }}"
        $(document).ready(function() {
            $(modal_id).modal('show');
        });
    </script>
@endif

@if (session()->has('success_msg'))
    @php $msg=session()->get('success_msg'); @endphp
    <script>
        var success_msg = "<?php echo "$msg"; ?>";
        console.log(success_msg);
        Swal.fire({
            text: success_msg,
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
    @php session()->forget('success_msg'); @endphp
@elseif(session()->has('error_msg'))
    @php $msg=session()->get('error_msg'); @endphp
    <script>
        var error_msg = "<?php echo "$msg"; ?>";
        console.log(error_msg);
        Swal.fire({
            text: error_msg,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
    @php session()->forget('error_msg'); @endphp
@endif
<!--end::Javascript-->
