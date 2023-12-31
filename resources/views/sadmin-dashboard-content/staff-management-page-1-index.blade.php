@extends('sadmin-dashboard-layout.dashboard-template')

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



    <div class="card">
        <div class="card-body">

            <h3 class="panel-title" style="text-align:center; color:black; font-weight:bold;">Register Users</h3>
            <br>

            <form action="/insert-staff-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="color: black;" class="form-row">

                    <div class="col-md-4 mb-3">
                        <label for="staff_id">Roll No.</label>
                        <input type="text" class="form-control" id="staff_id" name="staff_id"
                            placeholder="Enter Roll No." autocomplete="off" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="Enter First Name" autocomplete="off" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Enter Last Name" autocomplete="off" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                            autocomplete="off" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email">BIT Sathy mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter Email Address" autocomplete="off" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            placeholder="Enter Phone Number" autocomplete="off" required>
                    </div>
                </div>
                <input style = "background-color:#c54f4f;" class="btn   btn-primary" value="Register" type="submit">
            </form>

        </div>
    </div>

    <br>

    <div style="margin-bottom: 20px;" class="card">
        <div class="card-body" style="overflow:scroll">

            <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless table-hover table-dark">
                <thead style="border-bottom:2px solid white">
                    <tr style="white-space: nowrap">
                        <th scope="col">#</th>
                        <th scope="col">Staff ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        {{-- <th scope="col">Position</th> --}}
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staff_data as $key => $data)
                        <tr style="white-space: nowrap">
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $data->staff_id }}</td>
                            <td>{{ $data->firstname }}</td>
                            <td>{{ $data->lastname }}</td>
                            <td>{{ $data->dob }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phone_number }}</td>
                            {{-- <td>{{$data->position}}</td> --}}
                            <td><a style = "background-color:blue;" class="btn btn-primary" href="/view-staff-management-edit/{{ $data->auto_id }}">Edit</a>
                                <a class="btn btn-danger confirmation"
                                    href="/delete-staff-data/{{ $data->auto_id }}">Delete</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>



            <form action="/import-data" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group  col-sm-8">
                    <input type="file" name="xlupload" class="col-sm-5 choose">
                    <button class="btn btn-outline-primary file" type="submit">Upload</button>
                </div>
            </form>

        </div>
    </div>





@endsection
