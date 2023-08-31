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

    <div class="card">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;">Events</h3>
            <br>

            <form action="/event" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="eventname" class="col-sm-2 col-form-label">Event Name</label>
                    <div class="col-sm-8">
                        <input type="text" list="browsers" class="form-control" autocomplete="off" id="eventname"
                            name="eventname" placeholder="Event name" required>

                        <datalist id="browsers">
                            @foreach ($Search_Item as $item)
                                <option value="{{ $item->event_name }}">
                            @endforeach
                        </datalist>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="fromdate" class="col-sm-2 col-form-label">From Date</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="fromdate" name="fromdate" placeholder="From date"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="todate" class="col-sm-2 col-form-label">To Date</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="todate" name="todate" placeholder="To date"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="venue" class="col-sm-2 col-form-label">Venue</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="venue" name="venue" placeholder="" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label style="visibility:hidden;" for="button" class="col-sm-2 col-form-label">button</label>
                    <div class="col-sm-8">
                        <input style="background-color:#c54f4f" class="btn btn-primary col-md-2 col-sm-12" value="Submit" id="button" type="submit">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <br>
    <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Event_Name</th>
                <th scope="col">From_Date</th>
                <th scope="col">To_date</th>
                <th scope="col">Venue</th>
                <th scope="col">Students_Count</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($Event_Data as $key => $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->event_name }}</td>
                    <td>{{ $data->from_date }}</td>
                    <td>{{ $data->to_date }}</td>
                    <td>{{ $data->venue }}</td>
                    @if ($data->count === null)
                        <td>0</td>
                    @else
                        <td>{{ $data->count }}</td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
