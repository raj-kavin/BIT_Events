@extends('sadmin-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')
    <center>
        <h3>{{ $date }}</h3>
    </center>
    <br>
    <center>
        <div style="height:450px ; width:670px ; overflow-y:scroll;">
            <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless   table-hover table-dark">
                <thead style="border-bottom:2px solid white">
                    <center>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Staff Name</th>
                            <th scope="col">Time</th>


                        </tr>
                    </center>
                </thead>
                <tbody>
                    @foreach ($staffdata as $data)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $data->staff_id }}</td>
                            <td>{{ $data->request_time }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <a href="/view-attendance-log"  class="btn btn-danger">Back</a>
        </div>

        
    </center>
@endsection
