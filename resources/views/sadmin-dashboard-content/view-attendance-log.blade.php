@extends('sadmin-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')
    {{-- <pre>{{ json_encode($Staff_Counts, JSON_PRETTY_PRINT) }}</pre>
<pre>{{ json_encode($Student_Counts, JSON_PRETTY_PRINT) }}</pre> --}}

    <center>
        <h3 class="panel-title" style="color: black; font-weight:bold;">Attendence Log</h3>
    </center> <br>

    <div style="display:flex; flex-direction:row ; gap:130px">
        <table style="background-color: #1c1940; color:white; border-radius:25px;"
            class="table table-borderless  table-hover table-dark">
            <thead style="border-bottom:2px solid white">
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
                        <td>{{ $data->date_of_request }}      <a style="color: white;text-decoration:none;"
                                href="/view-student-attendances/{{ $data->date_of_request }}"><i class="fa-solid fa-eye"></i><a>
                        </td>
                        <td>{{ $data->student_count }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <table style="background-color: #1c1940; color:white; border-radius:25px;"
            class="table table-borderless  table-hover table-dark">
            <thead style="border-bottom:2px solid white">
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
                        <td>{{ $data->date_of_request }}            <a style="color: white;text-decoration:none;"
                                href="/view-staff-attendances/{{ $data->date_of_request }}"><i class="fa-solid fa-eye"></i></a>
                        </td>
                        <td>{{ $data->staff_count }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
