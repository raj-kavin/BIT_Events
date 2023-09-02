@extends('mentor-dashboard-layout.dashboard-template')





@section('dashboard-admin-content')


<center>
    <h3> Event Attendance </h3>
</center>
<br>
<center>
    <div style="height:450px ; width:670px ; overflow-y:scroll;">
        <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless   table-hover table-dark">
            <thead style="border-bottom:2px solid white">
                <center>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student Name</th>



                    </tr>
                </center>
            </thead>
            <tbody>
                @foreach ($register_data as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->username }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>

        <a href="/view-event-index" class="btn btn-danger">Back</a>
    </div>
</center>



@endsection
