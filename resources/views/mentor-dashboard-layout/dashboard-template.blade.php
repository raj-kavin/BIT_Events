<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('dashboard-template') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Iceland&display=swap" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('dashboard-template') }}/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard-template') }}/css/app.css">

    <style>
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }


        ::-webkit-scrollbar-thumb:hover {
            background: #555;
            border-radius: 4px;
        }

        .panel-title {
            font-family: 'Iceland';
            font-size: 35px;
            color: black;
            font-weight: bold
        }

        * {
            font-family: 'Poppins';
        }

        .nav-item:hover {
            background-color: #c54f4f;
            border-radius: 25px;
            /* Replace with your desired color */
        }

        .header:hover {
            background: none;
        }

        .nav-item.active {
            background-color: #c54f4f;
            border-radius: 25px;
            /* Replace with your desired color */
        }

        .card {
            border-radius: 25px;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
        }

        .side-nav {
            margin-left: 15% !important;
            background-color: black;
            /* font-size: 152px */
        }

        .nav {

            color: white;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding-bottom: 10px;
            padding-left: 15px;
            padding-right: 5px;
            padding-top: 10px;
            gap: 10px;
            text-align: center;



        }

        .nav:hover {
            text-decoration: none;
            color: white;
        }

        .side-nav-closed {
            margin-left: 8%
        }

        .wholeNavbar {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style=" background-color:#1c1940 ; z-index: 1000;"
            class="navbar-nav position-fixed z-index-2 sidebar sidebar-dark accordion bg-gradient-primary"
            id="accordionSidebar">
            {{-- bg-gradient-primary --}}

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div style="color:white" class="sidebar-brand-text mx-3">BIT Camps</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <div class="wholeNavbar">
                <li class="nav-item">
                    <a class="nav-link" href="/view-home-page">
                        <i class="fa-solid fa-house" style="font-size:15px"></i>
                        <span>Home</span></a>
                </li>

                <!-- <li class="nav-item">
                <a class="nav-link" href="/view-staff-management-index">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Student List</span></a>
            </li> -->

                {{-- <li class="nav-item">
                <a class="nav-link" href="/view-leave-history">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Leave Log</span></a>
            </li> --}}

                {{-- <li class="nav-item">
                <a class="nav-link" href="/view-user-accounts-index">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Accounts Manage</span></a>
            </li> --}}
                @if (Session::get('Session_Type') == 'staff')
                    <li class="nav-item">
                        <a class="nav-link" href="/view-event-index">
                            <i class="fa-solid fa-calendar-days" style="font-size:18px"></i>
                            <span>Event</span></a>
                    </li>
                @endif
                @if (Session::get('Session_Type') == 'student')
                    <li class="nav-item">
                        <a class="nav-link" href="/view-events">
                            <i class="fa-solid fa-registered" style="font-size:18px"></i>
                            <span>Events Registration</span></a>
                    </li>
                @endif
                {{-- <li class="nav-item">
                    <a class="nav-link" href="/view-settings-index">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Settings</span></a>
                </li> --}}


                @if (Session::get('Session_Type') == 'staff')
                    <li class="nav-item">
                        <a class="nav-link" href="/view-events-approval/{{ Session::get('Session_Id') }}">
                            <i class="fa-solid fa-plus" style="font-size:18px"></i>
                            <span>Create Events</span></a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="/handle-logout">
                        <i class="fa-solid fa-right-from-bracket" style="font-size:15px"></i>
                        <span>Logout</span></a>
                </li>
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" onclick="callfun()"></button>
            </div>

            <!-- Sidebar Message -->


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" style="" class="d-flex flex-column z-index-0 side-nav side-nav-closed">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="textToConvert" class="mr-3 d-none d-lg-inline"
                                    style="font-size: 18px; font-weight: bold;">{{ Session::get('Session_Value') }}
                                    ({{ Session::get('Session_Type') }} )</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('dashboard-template') }}/img/undraw_profile.svg">
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="min-height: 580px">


                    @yield('dashboard-admin-content')


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>
                            &copy; Copyright <b><i>Hypertext_Assasins</i></b> | All rights reserved | Co-created by <a
                                style="color:#56509f; font-weight:bold;" href="https://www.bitsathy.ac.in/"
                                target="_blank">BIT Team</a>
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('dashboard-template') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('login-template') }}/js/jquery.min.js"></script>
    <script src="{{ asset('login-template') }}/js/popper.js"></script>
    <script src="{{ asset('login-template') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('login-template') }}/js/main.js"></script>
    <script src="{{ asset('dashboard-template') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('dashboard-template') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('dashboard-template') }}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('dashboard-template') }}/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('dashboard-template') }}/js/demo/chart-area-demo.js"></script>
    <script src="{{ asset('dashboard-template') }}/js/demo/chart-pie-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <script src="{{ asset('dashboard-template') }}/sweetalert/sweetalert.min.js"></script>
    <script src="{{ asset('dashboard-template') }}/webcamjs/webcam.min.js"></script>
    <script src="{{ asset('dashboard-template') }}/main.js"></script>

    <script src="https://kit.fontawesome.com/4b5150bf42.js" crossorigin="anonymous"></script>
    <script>
        function callfun() {

            const content = document.getElementById("content-wrapper");
            const classLists = content.classList;
            if (classLists.contains("side-nav")) {
                content.classList.remove("side-nav");
            } else {
                content.classList.add("side-nav");
            }
        }
    </script>
    <script>
        $(document).ready(function() {

            var path = window.location.pathname;

            $('.nav-item a[href="' + path + '"]').parent().addClass('active');

        });
    </script>



</body>

</html>
