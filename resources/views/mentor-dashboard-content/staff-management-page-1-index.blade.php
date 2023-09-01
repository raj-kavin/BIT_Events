@extends('mentor-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="errorBox" style="text-align:center;margin-top:20px;"
                class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
                <strong style="color: white">{!! $error !!}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
    <br>

    <div class="card">
        <div class="card-body" style="overflow: scroll">

            <table class="table table-bordered table-hover table-dark">
                <thead style="border-bottom:2px solid white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Staff ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Position</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staff_data as $key => $data)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $data->staff_id }}</td>
                            <td>{{ $data->firstname }}</td>
                            <td>{{ $data->lastname }}</td>
                            <td>{{ $data->dob }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phone_number }}</td>
                            {{-- <td>{{$data->position}}</td> --}}
                            <td><a class="btn btn-primary" href="/view-staff-management-edit/{{ $data->auto_id }}">Edit</a>
                                <a class="btn btn-danger confirmation"
                                    href="/delete-staff-data/{{ $data->auto_id }}">Delete</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>





@endsection

<script>
    window.onload = function() {
        $(".nav-item:eq(1)").addClass("active");

        $('.confirmation').on('click', function() {
            return confirm('Are you sure to delete?');
        });

    }
</script>
