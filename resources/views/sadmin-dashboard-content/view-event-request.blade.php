@extends('sadmin-dashboard-layout.dashboard-template')

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

    <div class="card">
        <br>
        <h3 class="panel-title" style="color:black; font-weight:bold; text-align:center;">Event Requests</h3>
        <div class="card-body" style="display: flex; flex-wrap:wrap;justify-content:center;gap:10px;">

            <br>



            @foreach ($Event_request as $key => $data)
                <div style="background-color: #1c1940; color:white; border-radius:25px;width:500px; "
                    class="card text-white mb-3">
                    <div style="background-color: #1c1940; color:white; border-radius:25px" class="card-body ">
                        <div style="display: flex;flex-direction:row;justify-content:space-between;align-items:center">
                            <div class="float-left text-lg"> <strong>Req By : {{ $data->User_Name }}</strong><br></div>
                            <div><a style="margin-left:10px;" class="btn btn-danger  float-right "
                                    href="decline-event-request/{{ $data->id }}">Decline</a>
                                <a style="background-color:blue" class="btn btn-primary float-right"
                                    href="accept-event-request/{{ $data->id }}">Accept</a>
                            </div>
                        </div>

                        <br>
                        <div style="display: flex;justify-content:space-between;">
                            <div>Event Name : <strong>{{ $data->event_name }}</strong><br>Event Venue :
                                <strong>{{ $data->event_venue }}</strong></div>

                            <div style="text-align: end">From Date : <strong>{{ $data->F_date }}</strong> <br>To Date :
                                <strong>{{ $data->T_date }}</strong></div>
                        </div>



                    </div>
                </div>
            @endforeach



        </div>
    </div>

    {{-- <center>
    <h3>Event Request</h3>
</center>
<br>
<center>
    <div style="height:450px ; width:670px ; overflow-y:scroll;">
        <table class="table table-bordered   table-hover table-dark">
            <thead>
                <center>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Event Name</th>
                        <th scope="col">Event Venue</th>
                        <th scope="col">From Date</th>
                        <th scope="col">From Date</th>
                    </tr>
                </center>
            </thead>
            <tbody>
                @foreach ($Event_request as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->User_Id }}</td>
                        <td>{{ $data->event_name }}</td>
                        <td>{{ $data->event_venue }}</td>
                        <td>{{ $data->F_date }}</td>
                        <td>{{ $data->T_date }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</center> --}}
@endsection
