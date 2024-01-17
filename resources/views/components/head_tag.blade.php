<!--begin::Head-->

<head>
    <base href="{{ url('/') }}" />
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8" />

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <link rel="canonical" href="{{ url('/') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/shorticon.png') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script src="https://unpkg.com/peerjs@1.3.2/dist/peerjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js" integrity="sha512-zoJXRvW2gC8Z0Xo3lBbao5+AS3g6YWr5ztKqaicua11xHo+AvE1b0lT9ODgrHTmNUxeCw0Ry4BGRYZfXu70weg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    {{-- datatables --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"> --}}

    <style>
        #kt_app_main.loading::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-container {
            display: none;
        }

        #kt_app_main.loading .loader-container {
            display: flex;
        }

        .loading-spinner {
            border: 5px solid rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            border-top: 5px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        #loader.show {
            display: flex;
        }

        body.loading {
            overflow: hidden;
            /* Prevent scrolling when loader is shown */
        }

        body.loading::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Adjust the opacity as needed */
            z-index: 9998;
        }
    </style>


</head>
<!--end::Head-->
