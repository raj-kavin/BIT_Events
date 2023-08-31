@extends('sadmin-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')
    {{-- <pre>{{ json_encode($Staff_Counts, JSON_PRETTY_PRINT) }}</pre>
<pre>{{ json_encode($Student_Counts, JSON_PRETTY_PRINT) }}</pre> --}}

<center><h3>Attendence Log</h3></center> <br>
    <table class="table table-bordered  table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Student Count</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($Student_Counts as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td><a style="color: white" href="/view-student-attendances/{{$data->date_of_request}}">{{ $data->date_of_request }}<a></td>
                    <td>{{ $data->student_count }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <table class="table table-bordered  table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Staff Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Staff_Counts as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td><a style="color: white"  href="/view-staff-attendances/{{$data->date_of_request}}">{{ $data->date_of_request }}</a></td>
                    <td>{{ $data->staff_count }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>


@endsection
