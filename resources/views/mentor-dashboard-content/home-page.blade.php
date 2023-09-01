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
            <strong> Attendance Marken sucessfully from location : {{ session()->get('message') }}</strong>
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


    <div class="card">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;">Mark Attendence</h3>
            <br>

            @csrf
            <center>
                <button style="background-color:#c54f4f" class="btn btn-warning text-white" id="accesscamera" data-toggle="modal" data-target="#photoModal">
                    Mark Attendance
                </button>
            </center>
        </div>

        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title" id="exampleModalLabel">Capture Photo</h5>
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
                        <button style="background-color:#c54f4f" type="button" class="btn btn-warning mx-auto text-white" id="takephoto">Capture
                            Photo</button>
                        <button style="background-color:#c54f4f" type="button" class="btn btn-warning mx-auto text-white d-none"
                            id="retakephoto">Retake</button>
                        <button style="background-color:blue"type="submit" class="btn btn-primary mx-auto text-white d-none" id="uploadphoto"
                            form="photoForm">Mark</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <div class="card">
        <div class="card-body" style="overflow: scroll">
            <h3 class="panel-title" style="text-align:center;">Attendance Details</h3>
            <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless table-hover table-dark">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $datas)
                      <tr>
                          <th scope="row">{{ $key + 1 }}</th>
                          <td>{{$datas->date_of_request}}</td>
                          <td>{{$datas->request_time}}</td>
                      </tr>

                  @endforeach

                </tbody>
            </table>

        </div>
  </div>

{{--
  <pre>{{ json_encode($imgdata, JSON_PRETTY_PRINT) }}</pre> --}}

<script>

    // JavaScript code
fetch('http://api.ipstack.com/check?access_key=YOUR_API_KEY')
    .then(response => response.json())
    .then(data => {
        var userLocation = {
            latitude: data.latitude,
            longitude: data.longitude
        };

        console.log("Latitude: " + userLocation.latitude);
        console.log("Longitude: " + userLocation.longitude);

        // Use the location data as needed in your application.
    })
    .catch(error => {
        console.error('Error getting location:', error);
    });

</script>




@endsection
