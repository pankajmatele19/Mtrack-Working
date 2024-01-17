<!DOCTYPE html>
<html lang="en">
@include('users.authentication.components.header')
<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url("{{ asset('assets/media/auth/bg4.jpg') }}");
            }

            [data-bs-theme="dark"] body {
                background-image: url("{{ asset('assets/media/auth/bg4-dark.jpg') }}");
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Aside-->
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <!--begin::Logo-->
                    <a href="{{ url('/') }}" class="mb-7">
                        <img alt="Logo" src="{{ asset('assets/media/logos/mtrack2.png') }}" />
                    </a>
                    <!--end::Logo-->
                    {{-- <!--begin::Title-->
						<h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>
						<!--end::Title--> --}}
                </div>
                <!--begin::Aside-->
            </div>
            <!--begin::Aside-->
            @yield('content')
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    @include('users.authentication.components.footer')

    @yield('script')
</body>
<!--end::Body-->

</html>
