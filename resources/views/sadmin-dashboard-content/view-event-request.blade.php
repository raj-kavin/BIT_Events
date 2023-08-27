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
    <div class="card-body">
      <h3 class="panel-title" style="text-align:center;">Event Requests</h3>
      <br>



      @foreach ($Event_request as $key => $data)

          <div class="card text-white bg-dark mb-3">
            <div class="card-header bg-dark ">
                User_Name : <strong>{{ $data->User_Id }}({{ $data->User_Name }})</strong><br>Event Name : <strong>{{ $data->event_name }}</strong><br>Event Venue : <strong>{{ $data->event_venue }}</strong>
                <br>From Date : <strong>{{ $data->F_date}}</strong> <br>To Date : <strong>{{ $data->T_date}}</strong>


            </div>
            <div class="card-body">

              <a style="margin-left:10px;" class="btn btn-danger  float-right " href="decline-event-request/{{$data->id}}">Decline</a>
              <a class="btn btn-primary float-right" href="accept-event-request/{{$data->id}}">Accept</a>

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
