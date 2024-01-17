@extends('users.authentication.master')
@section('content')
    <style>
        .otp-input {
        width: 4vmax;
        }

        .otp-input:focus {
            color: #495057;
            background-color: #fff;
            border-color: #3e97ff;
            outline: 0;
            box-shadow: none;
        }
    </style>
    @php
        if(session()->has('otp_sent'))
        {
            $otp_details=session()->get('otp_sent');
        }
    @endphp
    <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <!--begin::Form-->
                    <form id="otp-verification-form" class="form w-100" action="{{url('/verify_otp')}}" method="POST">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">Enter OTP</h1>
                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-500 fw-semibold fs-6">Enter OTP received on your email to verify your email.</div>
                            <!--end::Link-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            {{-- <!--begin::Email-->
                            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Email--> --}}
                            <div class="d-flex flex-row mt-5 justify-content-between">
                                <input minlength="1" maxlength="1" type="text" class="form-control otp-input text-center" autofocus="">
                                <input minlength="1" maxlength="1" type="text" class="form-control otp-input text-center">
                                <input minlength="1" maxlength="1" type="text" class="form-control otp-input text-center">
                                <input minlength="1" maxlength="1" type="text" class="form-control otp-input text-center">
                                <input type="hidden" name="email" value="{{isset($otp_details['email']) ? $otp_details['email'] : ""}}">
                                <input type="hidden" name="verification_otp" value="">
                            </div>
                            <span class="field_errors" style="color: rgb(230, 33, 33)">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                            <div class="text-center mt-5">
                                <span class="d-block mobile-text">Don't receive the OTP? <a id="resendotp" href="">Resend</a></span>
                            </div>
                        </div>
                        <!--begin::Actions-->
                        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                            <button type="submit" class="btn btn-primary me-4">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Submit</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                            <a href="{{url('/sign_in')}}" class="btn btn-light">Cancel</a>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Footer-->
                <div class="d-flex flex-stack px-lg-10">
                    <!--begin::Languages-->
                    <div class="me-0">
                        <!--begin::Toggle-->
                        <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="assets/media/flags/united-states.svg" alt="" />
                            <span data-kt-element="current-lang-name" class="me-1">English</span>
                            <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                        </button>
                        <!--end::Toggle-->
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">English</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/spain.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Spanish</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/germany.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">German</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/japan.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Japanese</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="assets/media/flags/france.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">French</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Languages-->
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        <a href="../../demo1/dist/pages/team.html" target="_blank">Terms</a>
                        <a href="../../demo1/dist/pages/pricing/column.html" target="_blank">Plans</a>
                        <a href="../../demo1/dist/pages/contact.html" target="_blank">Contact Us</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Card-->
        </div>
    <!--end::Body-->
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.otp-input').on('input', function() {
                var $this = $(this);
                if ($this.val().length >= $this.attr('maxlength')) {
                    $this.next('.otp-input').focus();
                    checkOTPBoxesFilled();
                }
            });

            $('.otp-input').on('paste', function(e) {
                var clipboardData = e.originalEvent.clipboardData || window.clipboardData;
                var pastedData = clipboardData.getData('Text');
                e.preventDefault();
                var otp = pastedData;
                for (var i = 0; i < otp.length && i < 4; i++) {
                    $('.otp-input:eq(' + i + ')').val(otp[i]);
                }
                checkOTPBoxesFilled();
            });

            function checkOTPBoxesFilled() {
                var count = 4;
                var otp = '';
                $('.otp-input').each(function(){
                    if($(this).val() != ""){
                        otp += $(this).val();
                        count--;
                    }
                });

                if(count === 0){
                    $("input[name=verification_otp]").val(otp)
                    $('#otp-verification-form').submit();
                }

            }

            $(document).on('click','#resendotp',function(e){
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "/verify_otp",
                    data: {
                        email: $('input[name="email"]').val()
                    },
                    success: function (response) {
                        if(response['success_msg'])
                        {
                            Swal.fire({
                                text: response['success_msg'],
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                        else
                        {
                            Swal.fire({
                                text: response['error_msg'],
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
