@extends('mentor-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="" stylerrorBoxe="text-align:center;margin-top:20px;"
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

            <h3 class="panel-title" style="text-align:center;">Leave Logs</h3>
            <br>

            <form action="/filter-search-leave-history-controller" method="POST">
                {{ csrf_field() }}
                <div class="form-row">

                    <div class="col-md-4 mb-3">
                        <label for="staff_id">Select Student</label>

                        <select class="form-control" name="staff_id" id="staff_id" aria-label="Default select example"
                            required>

                            <option value="Select a staff" selected disabled>Select a student</option>
                            @foreach ($staff_basic_data as $key => $data)
                                <option value="{{ $data->staff_id }}">{{ $data->staff_id }} ({{ $data->firstname }}
                                    {{ $data->lastname }})</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="type_of_leave">Type of Leave</label>

                        <select class="form-control" name="type_of_leave" id="type_of_leave"
                            aria-label="Default select example" required>

                            <option value="All" selected>All</option>
                            <option value="Sick leave">Sick leave</option>
                            <option value="Casual leave">Casual leave</option>
                            <option value="Duty Leave">Onduty Leave</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="year">Year</label>
                        <select class="form-control" name="year" id="year" aria-label="Default select example"
                            required>
                            <option value="All" selected>All</option>
                            <option value='2021'>2021</option>
                            <option value='2022'>2022</option>
                            <option value='2023'>2023</option>
                            <option value='2024'>2024</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="month">Month</label>
                        <select class="form-control" name="month" id="month" aria-label="Default select example"
                            required>
                            <option value="All" selected>All</option>
                            <option value='01'>January</option>
                            <option value='02'>February</option>
                            <option value='03'>March</option>
                            <option value='04'>April</option>
                            <option value='05'>May</option>
                            <option value='06'>June</option>
                            <option value='07'>July</option>
                            <option value='08'>August</option>
                            <option value='09'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>

                        <select class="form-control" name="status" id="status" aria-label="Default select example"
                            required>
                            <option value="All" selected>All</option>
                            <option value="[ACCEPTED]">Accepted</option>
                            <option value="[DECLINED]">Declined</option>
                        </select>

                    </div>

                </div>
                <input class="btn btn-primary float-right" value="Search" type="submit">
            </form>

        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;">My Leave History</h3>

            <h4>Number of Leaves: <span style="text-weight:bold; color:blue;">{{ count($leave_data) }}</span> </h4>

            <hr>

            <br>

            @foreach ($leave_data as $key => $data)
                <div class="card text-white bg-dark mb-3">
                    @if ($data->approval_status == '[ACCEPTED]')
                        <div class="card-header bg-success">
                            <strong>From Date: {{ $data->from_date }} To Date: {{ $data->to_date }} Session:
                                {{ $data->session }}(Accepted)</strong>
                            <i class="float-right" style="font-size:85%;">Request sent on :-
                                {{ $data->date_of_request }}</i>
                        </div>
                    @elseif($data->approval_status == '[DECLINED]')
                        <div class="card-header bg-danger">
                            <strong>From Date: {{ $data->from_date }} To Date: {{ $data->to_date }} Session:
                                {{ $data->session }}(Declined)</strong>
                            <i class="float-right" style="font-size:85%;">Request sent on :-
                                {{ $data->date_of_request }}</i>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $data->type_of_leave }}</h5>
                        <p class="card-text">{{ $data->description }}</p>
                    </div>
                </div>
            @endforeach



        </div>
    </div>

@endsection

<script>
    window.onload = function() {

        $(".nav-item:eq(2)").addClass("active");

        $('.confirmation').on('click', function() {
            return confirm('Are you sure to delete?');
        });


        $('#staff_id').val("{{ $filter_options['staff_id'] }}");
        $('#type_of_leave').val("{{ $filter_options['type_of_leave'] }}");
        $('#year').val("{{ $filter_options['year'] }}");
        $('#month').val("{{ $filter_options['month'] }}");
        $('#status').val("{{ $filter_options['status'] }}");
    }
</script>
