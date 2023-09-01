@extends('mentor-dashboard-layout.dashboard-template')





@section('dashboard-admin-content')
    @if (session()->has('message'))
        <div id="successBox" style="text-align:center;margin-top:20px;"
            class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
            <strong> {{ session()->get('message') }}</strong>
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
    <div style="margin-bottom: 20px;" class="card">
        <div class="card-body" style="overflow:scroll">
            <center>
                <h3 class="panel-title" style="color: black; font-weight:bold;">Register Events</h3>
            </center>
            <table style="background-color: #1c1940; color:white; border-radius:25px;"
                class="table table-borderless table-hover table-dark">
                <thead style="border-bottom:2px solid white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event_Name</th>
                        <th scope="col">From_Date</th>
                        <th scope="col">To_date</th>
                        <th scope="col">Venue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Event_Datas as $key => $data)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $data->event_name }}</td>
                            <td>{{ $data->from_date }}</td>
                            <td>{{ $data->to_date }}</td>
                            <td>{{ $data->venue }}</td>

                            <td><a class="btn btn-danger" href="/register-event/{{ $data->id }}">Register</a>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>


    {{-- <pre>{{ json_encode($Event_Data, JSON_PRETTY_PRINT) }}</pre> --}}



    <div style="margin-bottom: 20px;" class="card">
        <div class="card-body" style="overflow:scroll">
            <center>
                <h3 class="panel-title" style="color: black; font-weight:bold;">Event Attendance</h3>
            </center>
            <table style="background-color: #1c1940; color:white; border-radius:25px;"
                class="table table-borderless table-hover table-dark">
                <thead style="border-bottom:2px solid white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event_Name</th>
                        <th scope="col">From_Date</th>
                        <th scope="col">To_date</th>
                        <th scope="col">Venue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Event_Data as $key => $data)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $data->event_name }}</td>
                            <td>{{ $data->from_date }}</td>
                            <td>{{ $data->to_date }}</td>
                            <td>{{ $data->venue }}</td>

                            <td><a class="btn btn-danger" href="/insert-event-attendance/{{ $data->event_id }}">Mark</a>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
        @endsection
