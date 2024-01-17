<!DOCTYPE html>
<html lang="en">
{{-- head_tag --}}
@include('components.head_tag')
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
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
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            @include('components.header')

            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                @include('components.sidebar')

                <!--begin::Main-->
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-fluid">
                        <!--begin::Carousel-->
                        <div id="kt_security_guidelines" class="carousel carousel-custom carousel-stretch slide" data-bs-ride="carousel" data-bs-interval="8000">
                            <!--begin::Heading-->
                            <div class="d-flex flex-stack align-items-center flex-wrap">
                                <h3 class="fw-bold my-2">Live Employees ({{ $liveEmployeesCount }})</h3>
                                <!--begin::Carousel Indicators-->

                                <!--end::Carousel Indicators-->
                            </div>
                            <!--end::Heading-->
                            @include('employees.emp_cards_dashboard')
                            <!--<div class="carousel-inner pt-6">
                                
                            </div>-->
                        </div>
                    </div>
                </div>
                <!--end:::Main-->
                <!--begin::Modal - employee_screen-->
                <div class="modal fade" id="kt_modal_view_employee_screening" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-1000px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_view_employee_screening_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Employee Screening</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div id="kt_modal_close_view_employee_screening" class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <i class="ki-duotone ki-cross fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <!--<div class="modal-body" id="kt_modal_view_employee_screening_scroll">
                                <div id="video-grid">
                                    {{-- <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/Kd2P-1FY4Hc?si=WhgAJWVifnqEq-c3"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe> --}}
                                </div>
                            </div>-->
                            <!--end::Modal body-->
                        </div>
                    </div>
                </div>
                @include('components.footer')
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Scrolltop-->
    @include('components.scripts')
    <script>
        document.querySelectorAll('.emp_card').forEach(card => {
            card.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', card.id);
                card.setAttribute('data-x', e.clientX);
                card.setAttribute('data-y', e.clientY);
            });

            card.addEventListener('dragend', (e) => {
                const x = parseInt(card.style.left || 0) + e.clientX - parseInt(card.getAttribute('data-x'));
                const y = parseInt(card.style.top || 0) + e.clientY - parseInt(card.getAttribute('data-y'));
                card.style.left = x + "px";
                card.style.top = y + "px";
            });
        });
        // Resizable Functionality
        document.querySelectorAll('.resizer').forEach(resizer => {
            resizer.addEventListener('mousedown', (e) => {
                e.preventDefault();

                document.addEventListener('mousemove', handleMouseMove);
                document.addEventListener('mouseup', () => {
                    document.removeEventListener('mousemove', handleMouseMove);
                });

                function handleMouseMove(event) {
                    const card = resizer.parentElement;
                    card.style.width = event.clientX - card.getBoundingClientRect().left + "px";
                    card.style.height = event.clientY - card.getBoundingClientRect().top + "px";
                }
            });
        });
        /**$(document).ready(function() {
            $(document).on('click', '.view-screen', function() {
                $('#kt_modal_view_employee_screening').modal('show');
            });

            $(document).on('click', '#kt_modal_close_view_employee_screening', function(e) {
                e.preventDefault();
                $('#video-grid').empty();
                $('#kt_modal_view_employee_screening').modal('hide');
            });
        });**/
        document.addEventListener("DOMContentLoaded", function() {
            // Grab the Live button
            var liveButtons = document.querySelectorAll(".view-screen");

            liveButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    // Get the card containing the button
                    var card = button.closest('.emp_card');

                    // Hide the avatar, name, and position
                    var toHide = card.querySelector('.to-hide');
                    if (toHide) {
                        toHide.style.display = 'none';
                    }

                    // Show the video-container
                    var videoContainer = card.querySelector('[id^="video-container_"]');
                    if (videoContainer) {
                        videoContainer.style.display = 'block';
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Grab the Live button
            var liveButtons = document.querySelectorAll(".view-screen");

            liveButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    // Get the card containing the button
                    var card = button.closest('.emp_card');

                    // Hide the avatar, name, and position
                    var toHide = card.querySelector('.to-hide-live');
                    if (toHide) {
                        toHide.style.display = 'none';
                    }

                    // Show the video-container
                    var videoContainer = card.querySelector('[id^="video-container_"]');
                    if (videoContainer) {
                        videoContainer.style.display = 'block';
                    }
                });
            });
        });
    </script>
    <script>
        let userMediaStreamAdded = false;

        const mypeer = new Peer({
            host: "peer.m360tracker.com",
            secure: true,
            path: "/mtrack",
        });
        console.log("🚀  file: index.html:34  mypeer:", mypeer)

        // const viewscreen = document.getElementById("view-screen");
        // viewscreen.addEventListener("click", viewUserScreen);

        function createDummyStream({
            width,
            height
        }) {
            const canvas1 = document.createElement("canvas");
            canvas1.width = width;
            canvas1.height = height;

            const context1 = canvas1.getContext("2d");
            context1.fillStyle = "black"; // Fill the canvas with black color
            context1.fillRect(0, 0, width, height);

            const canvas2 = document.createElement("canvas");
            canvas2.width = width;
            canvas2.height = height;

            const context2 = canvas2.getContext("2d");
            context2.fillStyle = "black"; // Fill the canvas with black color
            context2.fillRect(0, 0, width, height);

            const videoStream1 = canvas1.captureStream(0); // Capture the first canvas as a video stream
            const videoTrack1 = videoStream1.getVideoTracks()[0];
            videoTrack1.enabled = false; // Mute the first video track

            const videoStream2 = canvas2.captureStream(0); // Capture the second canvas as a video stream
            const videoTrack2 = videoStream2.getVideoTracks()[0];
            videoTrack2.enabled = false; // Mute the second video track

            const audioContext = new AudioContext();
            const audioDest = audioContext.createMediaStreamDestination();
            const audioTrack = audioDest.stream.getAudioTracks()[0];
            audioTrack.enabled = false; // Mute the audio track

            return new MediaStream([videoTrack1, videoTrack2, audioTrack]);
        }

        $(document).on('click', '.view-screen', function() {
            var emp_id = $(this).attr('data-emp-id');
            var jwt_token;
            $.ajax({
                type: "GET",
                url: "",
                data: {
                    emp_id: emp_id,
                    page: "get_secret"
                },
                success: function(response) {
                    jwt_token = response['jwt_token'];
                    console.log(jwt_token);
                    viewUserScreen(emp_id, jwt_token, $(this).closest('.emp_card'));
                }
            });
        });

        function viewUserScreen(emp_id, jwt_token, cardElement) {
            userMediaStreamAdded = false;
            const token = jwt_token;
            socket = io.connect("https://api.m360tracker.com", {
                query: `token=${token}`
            });

            socket.on("connect", () => {
                try {
                    console.log(socket);
                    socket.emit("join room", {
                        employee_id: emp_id,
                    });

                    socket.on("user-connected", async (targetpeerid) => {
                        userMediaStreamAdded = false;

                        try {
                            // Create a MediaStream with both audio and video tracks

                            const stream = createDummyStream({
                                width: 640,
                                height: 480
                            });





                            console.log("user connected", targetpeerid);
                            const call = mypeer.call(targetpeerid, stream);

                            call.on("stream", (remotemediastream) => {
                                console.log(
                                    "🚀  file: index.html:41  socket.on ~ remotemediastream:",
                                    remotemediastream, userMediaStreamAdded
                                );

                                remotemediastream.getTracks().forEach((track) => {
                                    console.log(track, "tracks");
                                });

                                if (!userMediaStreamAdded) {

                                    addVideoStream(remotemediastream, emp_id);

                                }

                            });

                            call.on("error", function(err) {
                                console.log(err);
                            });
                        } catch (error) {
                            console.log(error);
                        }
                    });
                } catch (error) {
                    console.log(error);
                }
            });
        }

        const addVideoStream = (mediaStream, emp_id) => {
            userMediaStreamAdded = true;
            console.log(mediaStream, userMediaStreamAdded, "addvideo");
            const videoContainer = document.getElementById(`video-container_${emp_id}`);

            mediaStream.getTracks().forEach((track) => {
                if (track.kind === "video") {
                    const video = document.createElement("video");
                    video.classList.add('emp_screen');
                    video.srcObject = new MediaStream([track]);
                    video.controls = true;
                    video.addEventListener("loadedmetadata", () => {
                        video.play();
                    });
                    videoContainer.append(video);
                } else if (track.kind === "audio") {
                    const audio = document.createElement("audio");
                    audio.srcObject = new MediaStream([track]);
                    audio.addEventListener("loadedmetadata", () => {
                        audio.play();
                    });
                }
            });

        };
    </script>
</body>
<!--end::Body-->

</html>