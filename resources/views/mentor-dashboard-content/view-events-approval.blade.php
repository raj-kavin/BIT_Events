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


    <form action="/eventapproval" method="POST">
        @csrf
        <div class="d-flex justify-content-center align-items-center">
            <h3 class="panel-title" style="text-align:start;">Events Creation</h3>
        </div>


        <div class="card" id="firstForm">
            <div class="card-body">
                <h3 class="panel-title" style="text-align:start;">Events</h3>
                <br>
                <div class="form-group row">
                    <label for="eventname" class="col-sm-2 col-form-label">Event Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Event name"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fdate" class="col-sm-2 col-form-label">From Date</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="fdate" name="fdate" placeholder="From date"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tdate" class="col-sm-2 col-form-label">To Date</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="tdate" name="tdate" placeholder="To date"
                            required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="venue" class="col-sm-2 col-form-label">Venue</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="venue" name="venue" placeholder="" required>
                    </div>
                </div>


            </div>

        </div>

        <br>




        <div class="card" >
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="panel-title" style="text-align:start;">Venues</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="secondFormCheckBox">
                        <label class="form-check-label" for="flexCheckDefault">
                            Required
                        </label>
                    </div>
                </div>

                <div class="form-group row" id="secondForm">
                    <label for="eventname" class="col-sm-2 col-form-label">Venue Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="venuename" name="venuename" placeholder="venue name"
                            required>
                    </div>
                </div>


            </div>

        </div>
        <br>


        <div class="card" ">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="panel-title" style="text-align:start;">Guest</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="thirdFormCheckBox">
                        <label class="form-check-label" for="flexCheckDefault">
                            Required
                        </label>
                    </div>
                </div>

                <div class="form-group row" id="thirdForm">
                    <label for="guest" class="col-sm-2 col-form-label">Guest</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="guest" name="guest" placeholder="guest"
                            required>
                    </div>
                </div>


            </div>

        </div>
        <center>

            <div class="form-group row mt-5">
                <label style="visibility:hidden;" for="button" class="col-sm-2 col-form-label">button</label>
                <div class="col-sm-8">
                    <input style="background-color:#c54f4f" class="btn btn-primary col-md-2 col-sm-12" value="Submit" id="button" type="submit">
                </div>
            </div>

        </center>


    </form>

    <br>

    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large
        modal</button> --}}

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <table style="background-color: #1c1940; color:white; border-radius:25px;" class="table table-borderless  table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Event_Name</th>
                            <th scope="col">From_Date</th>
                            <th scope="col">To_date</th>
                            <th scope="col">Venue</th>
                            <th scope="col">Approval Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($Event_Request as $key => $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->event_name }}</td>
                                <td>{{ $data->F_date }}</td>
                                <td>{{ $data->T_date }}</td>
                                <td>{{ $data->event_venue }}</td>
                                <td>{{ $data->Approval_Status }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        let checkbox2 = document.getElementById('secondFormCheckBox');
        let secondForm = document.getElementById('secondForm');

        document.addEventListener("DOMContentLoaded", function() {
            second();
        });

        function second() {

            let secondinput = secondForm.querySelectorAll('input');

            if (checkbox2.checked) {
                secondinput.forEach(sinput => {
                    sinput.value = "";

                    secondForm.classList.remove("d-none");
                });
            } else {
                secondinput.forEach(sinput => {
                    if (sinput.type == 'date') {
                        sinput.value = "2023-08-22";
                    } else {
                        sinput.value = "NILL";
                    }
                    secondForm.classList.add("d-none");
                });
            }
        }

        checkbox2.addEventListener('click', function() {
            second();
        });

        let checkbox3 = document.getElementById('thirdFormCheckBox');
        let thirdForm = document.getElementById('thirdForm');

        document.addEventListener("DOMContentLoaded", function() {
            third();
        });

        function third() {

            let thirdinput = thirdForm.querySelectorAll('input');

            if (checkbox3.checked) {
                thirdinput.forEach(tinput => {
                    tinput.value = "";

                    thirdForm.classList.remove("d-none");
                });
            } else {
                thirdinput.forEach(tinput => {
                    if (tinput.type == 'date') {
                        tinput.value = "2023-08-22";
                    } else {
                        tinput.value = "NILL";
                    }
                    thirdForm.classList.add("d-none");
                });
            }
        }

        checkbox3.addEventListener('click', function() {
            third();
        });
    </script>
@endsection
