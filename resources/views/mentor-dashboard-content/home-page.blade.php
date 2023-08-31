@extends('mentor-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="errorBox" style="text-align:center;margin-top:20px;"
                class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
                <strong style="color:white;">{!! $error !!}</strong>
                <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>

            <script>
                window.onload = function() {

                    $("#errorBox").delay(3000).fadeOut("slow");

                }
            </script>
        @endforeach
    @endif


    @if (session()->has('message'))
        <div id="successBox" style="text-align:center;margin-top:20px;"
            class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
<<<<<<< HEAD
            {{-- <strong> Attendance Marken sucessfully from location : {{ session()->get('message') }}</strong> --}}
            <strong>{{ session()->get('message') }}</strong>
=======
            <strong> Attendance Marken sucessfully from location : {{ session()->get('message') }}</strong>
>>>>>>> ad2109f590cdb91a59b0210fb3774f9105417342
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <script>
            setTimeout(
                function() {
                    $("#successBox").delay(3000).fadeOut("slow");

                }, 1000);
        </script>
    @endif


<<<<<<< HEAD

    <div class="card">
        <div class="card-body">

=======
    <div class="card">
        <div class="card-body">
>>>>>>> ad2109f590cdb91a59b0210fb3774f9105417342
            <h3 class="panel-title" style="text-align:center;">Mark Attendence</h3>
            <br>
            {{-- <form action="/insert-leave-data-of-staff-account" method="POST" enctype=”multipart/form-data> --}}
            @csrf
            <center>
                <button class="btn btn-warning text-white" id="accesscamera" data-toggle="modal" data-target="#photoModal">
                    Capture Photo
                </button>
            </center>
        </div>

<<<<<<< HEAD
            {{-- <form action="/insert-leave-data-of-staff-account" method="POST" enctype="ultipart/form-data">
                @csrf



                <div class="form-group row">

                </div>
                <div class="form-group row ml-5">
                    <div class="col-sm-8 ml-5">
                       <center class="ml-5"> <div class="ml-5"><input class="btn btn-primary col-md-2 col-sm-12 ml-5" value="Mark" id="button" type="submit"> </div></center>
=======
        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Capture Photo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div id="my_camera" class="d-block mx-auto rounded overflow-hidden"></div>
                        </div>
                        <div id="results" class="d-none"></div>
                        <form method="post" id="photoForm" action="/insert-leave-data-of-staff-account">
                            @csrf
                            <input type="hidden" id="photoStore" name="photoStore" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning mx-auto text-white" id="takephoto">Capture
                            Photo</button>
                        <button type="button" class="btn btn-warning mx-auto text-white d-none"
                            id="retakephoto">Retake</button>
                        <button type="submit" class="btn btn-primary mx-auto text-white d-none" id="uploadphoto"
                            form="photoForm">Upload</button>
>>>>>>> ad2109f590cdb91a59b0210fb3774f9105417342
                    </div>
                </div>
            </div>
        </div>

<<<<<<< HEAD
            </form> --}}

            {{-- <form  id = "form" action="/store-photo" method="POST">
                @csrf --}}

                <input type="hidden" id="photoData" value="" name="photo_data">
                <button id="markButton" type="submit">Mark</button>

            {{-- </form> --}}

        </div>
    </div>
    <script>
        window.onload = function() {

            $(".nav-item:eq(0)").addClass("active");

        }


        // Get references to the button and image elements
        const markButton = document.getElementById("markButton");
        // const capturedImage = document.getElementById("capturedImage");
        const photoDataInput = document.getElementById("photoData");


        // Function to handle the button click
        markButton.addEventListener("click", async () => {

            event.preventDefault();
            try {
                // Request permission to access the user's camera
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });

                // Attach the camera stream to a video element
                const videoElement = document.createElement("video");
                videoElement.srcObject = stream;
                videoElement.autoplay = true;

                // Wait a moment to allow the camera to start
                await new Promise((resolve) => setTimeout(resolve, 1000));

                // Create a canvas to capture the photo
                const canvas = document.createElement("canvas");
                canvas.width = videoElement.videoWidth;
                canvas.height = videoElement.videoHeight;
                canvas.getContext("2d").drawImage(videoElement, 0, 0, canvas.width, canvas.height);

                // Convert the canvas image to a data URL
                const photoDataUrl = canvas.toDataURL("image/jpeg");

                photoDataInput.value = photoDataUrl;

                console.log(photoDataInput.value)

                // capturedImage.src = photoDataUrl;


                // Clean up by stopping the camera stream
                stream.getTracks().forEach((track) => track.stop());

                document.getElementById("form").submit();
            } catch (error) {
                console.error("Error capturing photo:", error);
            }
        });
    </script>


@endsection
=======
    @endsection
>>>>>>> ad2109f590cdb91a59b0210fb3774f9105417342
