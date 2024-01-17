<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('assets/') }}";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
<!--end::Custom Javascript-->
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
