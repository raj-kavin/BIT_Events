@extends('sadmin-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')
<center>
    <h3>{{ $date }}</h3>
</center>
<br>
<center>
    <div style="height:450px ; width:670px ; overflow-y:scroll;">
        <table class="table table-bordered   table-hover table-dark">
            <thead>
                <center>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Time</th>

                    </tr>
                </center>
            </thead>
            <tbody>
                @foreach ($studentdata as $data)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->staff_id }}</td>
                        <td>{{ $data->request_time }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</center>
@endsection
