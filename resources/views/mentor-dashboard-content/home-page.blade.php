@extends('mentor-dashboard-layout.dashboard-template')

@section('dashboard-admin-content')


@if($errors->any())
  @foreach ($errors->all() as $error)
      <div id="errorBox" style="text-align:center;margin-top:20px;" class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
          <strong style="color:white;">{!!$error!!}</strong>
          <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style="color:white;" >&times;</span>
          </button>
      </div>

      <script>

        window.onload=function(){

          $("#errorBox").delay(3000).fadeOut("slow");

        }

      </script>

  @endforeach
@endif


@if(session()->has('message'))

    <div id="successBox" style="text-align:center;margin-top:20px;" class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
        <strong> Attendance Marken sucessfully from location : {{ session()->get('message') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <script>

        setTimeout(
        function()
        {
            $("#successBox").delay(3000).fadeOut("slow");

        }, 1000);

    </script>

@endif



<div class="card">
    <div class="card-body">

      <h3 class="panel-title" style="text-align:center;">Mark Attendence</h3>
            <br>

            <form action="/insert-leave-data-of-staff-account" method="POST" enctype=”multipart/form-data>
                @csrf



                <div class="form-group row">

                </div>
                <div class="form-group row ml-5">
                    <div class="col-sm-8 ml-5">
                       <center class="ml-5"> <div class="ml-5"><input class="btn btn-primary col-md-2 col-sm-12 ml-5" value="Mark" id="button" type="submit"> </div></center>
                    </div>
                </div>

            </form>


    </div>
</div>



@endsection

<script>

    window.onload=function(){

      $(".nav-item:eq(0)").addClass("active");

    }

</script>
