@extends('sadmin-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="errorBox" style="text-align:center;margin-top:20px;"
                class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
                <strong style="color:white;">{!! $error !!}</strong>
                <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
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
            <h3 class="panel-title" style="text-align:center;color:black; font-weight:bold;">Create User Accounts</h3>
            <br>

            <form action="/insert-user-accounts" method="POST">

                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">User ID</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="staff_id" id="staff_id" aria-label="Default select example">

                            <option selected disabled>Select a ID</option>
                            @foreach ($staff_data as $key => $data)
                                <option value="{{ $data->staff_id }}">{{ $data->staff_id }} ({{ $data->firstname }}
                                    {{ $data->lastname }})</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Enter username" autocomplete="off" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="password" name="password"
                            placeholder="Enter password" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Account Type</label>
                    <div class="col-sm-8">
                        <select name="acc_type" id="acc_type" class="form-control">
                            <option selected disabled>Select Account Type</option>
                            <option value="sadmin">Super Admin</option>
                            <option value="staff">Staff</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <button type="button" class="btn btn-warning text-white col-sm-2 col-form-label" id="accesscamera" data-toggle="modal" data-target="#photoModal">
                        Upload Photo
                    </button>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="photoStore" name="photoStore" autocomplete="off" required>
                    </div>
                </div>

                {{-- <input type="text"  required> --}}
                <div class="form-group row">
                    <label style="visibility:hidden;" for="button" class="col-sm-2 col-form-label">button</label>
                    <div class="col-sm-8">
                        <input style = "background-color:#c54f4f;" class="btn btn-primary col-md-2 col-sm-12" value="Create" id="button" type="submit">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Capture Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div id="my_camera" class="d-block mx-auto rounded overflow-hidden"></div>
                    </div>
                    <div id="results" class="d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning mx-auto text-white" id="takephoto">Capture
                        Photo</button>
                    <button type="button" class="btn btn-warning mx-auto text-white d-none"
                        id="retakephoto">Retake</button>
                    <button type="" class="btn btn-success mx-auto text-white d-none" id="uploadphoto"
                        form="photoForm" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body" style="overflow: scroll">

            <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless table-hover table-dark">
                <thead style="border-bottom:2px solid white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Roll No.</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staff_user_data as $key => $data)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $data->staff_id }}</td>
                            <td>{{ $data->username }}</td>
                            <td>{{ $data->password }}</td>
                                <td><a style = "background-color:blue;" class="btn btn-primary" href="/view-edit-user-account/{{ $data->auto_id }}">Edit</a> <a
                                        class="btn btn-danger confirmation"
                                        href="/delete-user-account/{{ $data->auto_id }}">Delete</a></td>
                            </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>



@endsection


