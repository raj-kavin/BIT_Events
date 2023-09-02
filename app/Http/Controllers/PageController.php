<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Stroage;
use Illuminate\Support\Facades\Redirect;


class PageController extends Controller
{
    public function ViewLoginPageController()
    {

        return view("login-page");
    }

    public function ViewHomePageController()
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');
        $session_id = Session::get('Session_Id');


        if ($session_type == "staff" || $session_type == "student") {


             $pending_data = DB::select("SELECT date_of_request,request_time FROM leave_data WHERE staff_id = ? " , [$session_value]); // SQL-CODE

            return view("mentor-dashboard-content/home-page")->with(['data' => $pending_data]);
        } else {

            return Redirect::to("/");
        }
    }

    public function ViewStaffManagementIndexController()
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $staff_data = DB::table('staff_data')->get(); // Get staff data.
            return view("sadmin-dashboard-content/staff-management-page-1-index")->with('staff_data', $staff_data); //Send staff data with it.

        } else {

            return Redirect::to("/");
        }
    }

    public function ViewStaffManagementEditController($auto_id)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $staff_data = DB::table('staff_data')->where("auto_id", $auto_id)->get(); // Get staff data.
            return view("sadmin-dashboard-content/staff-management-page-2-edit")->with('staff_data', $staff_data); //Send staff data with it.

        } else {

            return Redirect::to("/");
        }
    }

    public function ViewSettingsPageContoller()
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            $admin_data = DB::table('user_account')->where("account_type", "admin")->get(); // Get staff data.
            return view("admin-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data); //Send staff data with it.

        } else if ($session_type == "staff") {
            $admin_data = DB::table('user_account')->where("account_type", "staff")->get(); // Get staff data.
            return view("mentor-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);
        } else if ($session_type == "student") {
            $admin_data = DB::table('user_account')->where("account_type", "student")->get(); // Get staff data.
            return view("slincharge-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);
        } else if ($session_type == "slhead") {
            $admin_data = DB::table('user_account')->where("account_type", "slhead")->get(); // Get staff data.
            return view("slhead-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);
        } else if ($session_type == "sadmin") {
            $admin_data = DB::table('user_account')->where("account_type", "sadmin")->get(); // Get staff data.
            return view("sadmin-dashboard-content/settings-page-1-index")->with('admin_data', $admin_data);
        } else {

            return Redirect::to("/");
        }
    }



    public function ViewUserAccountsIndexContoller()
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $staff_data = DB::select("SELECT * FROM staff_data WHERE staff_data.staff_id NOT IN (SELECT user_account.staff_id FROM user_account)"); // SQL-CODE
            $staff_user_data = DB::table('user_account')->get(); // Get staff data.

            return view("sadmin-dashboard-content/user-accounts-page-1-index")->with(['staff_user_data' => $staff_user_data, "staff_data" => $staff_data]); //Send staff data with it.

        } else {

            return Redirect::to("/");
        }
    }

    public function ViewEditUserAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $user_data = DB::table('user_account')->where(["auto_id" => $auto_id])->get();
            return view("sadmin-dashboard-content/user-accounts-page-2-edit")->with(['user_data' => $user_data]); //Send staff data with it.



        } else {

            return Redirect::to("/");
        }
    }

    public function ViewLeaveHistoryController()
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $staff_basic_data = DB::table('staff_data')->select("staff_id", "firstname", "lastname")->get();

            $leave_data = DB::table('leave_data')->where(["approval_status" => "[APPROVED]"])->orWhere("approval_status", "[DECLINED]")->orderBy('date_of_request', 'DESC')->get();

            return view("admin-dashboard-content/leave-management-page-1-index")->with(["staff_basic_data" => $staff_basic_data, "leave_data" => $leave_data, "filter_options" => ["staff_id" => "Select a staff", "type_of_leave" => "All", "year" => "All", "month" => "All", "status" => "All"]]); //Send staff data with it.

        } else {

            return Redirect::to("/");
        }
    }

    public function FilterSearchLeaveHistoryController(Request $request)
    {
        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            $session_value = Session::get('Session_Value');

            $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
            $SqlCode = "";


            $staff_id      =  $request->staff_id;
            $type_of_leave =  $request->type_of_leave;
            $year          =  $request->year;
            $month         =  $request->month;
            $status        =  $request->status;


            if ($type_of_leave == "All" && $year == "All" && $month == "All" && $status == "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE (approval_status  = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year == "All" && $month == "All" && $status == "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE type_of_leave = '$type_of_leave' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month == "All" && $status == "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '{$year}______%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month != "All" && $status == "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year == "All" && $month == "All" && $status != "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month == "All" && $status == "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month != "All" && $status == "All"  && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id'  ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month != "All" && $status != "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month == "All" && $status != "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month == "All" && $status != "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month != "All" && $status != "All" && $staff_id != "") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND approval_status = '$status' AND staff_id = '$staff_id' ORDER BY from_date DESC";
            } else {

                return redirect()->back()->withErrors("<strong>Wrong filter.</strong>");
            }

            $leave_data = DB::select($SqlCode); // SQL-CODE

            $staff_basic_data = DB::table('staff_data')->select("staff_id", "firstname", "lastname")->get();

            return view("admin-dashboard-content/leave-management-page-1-index")->with(["staff_basic_data" => $staff_basic_data, "leave_data" => $leave_data, "filter_options" => ["staff_id" => "$staff_id", "type_of_leave" => "$type_of_leave", "year" => "$year", "month" => "$month", "status" => "$status"]]); //Send staff data with it.


        } else {

            return Redirect::to("/");
        }
    }




    public function ViewHomePageOfStaffAccountController()
    {

        $session_type = Session::get('Session_Type');


        if ($session_type == "Staff") {

            $session_value = Session::get('Session_Value');

            $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
            $leave_pending_data = DB::table('leave_data')->where(["staff_id" => $session_value, "approval_status" => "[PENDING]"])->orderBy('from_date', 'ASC')->get();
            $username = DB::table('user_account')->select("username")->where(["staff_id" => $session_value])->get();

            return view("staff-dashboard-content/home-page-index")->with(['staff_basic_data' => $staff_basic_data, "username" => $username, "leave_pending_data" => $leave_pending_data]);
        } else {

            return Redirect::to("/");
        }
    }

    public function ViewSettingsPageOfStaffAccountContoller()
    {

        $session_type = Session::get('Session_Type');
        if ($session_type == "Staff") {

            $session_value = Session::get('Session_Value');

            $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            return view("staff-dashboard-content/settings-page-1-index")->with(['staff_data' => $staff_data, 'staff_basic_data' => $staff_basic_data]); //Send staff data with it.

        } else {

            return Redirect::to("/");
        }
    }

    public function ViewMyLeaveHistoryPageOfStaffAccountController()
    {


        $session_type = Session::get('Session_Type');

        if ($session_type == "Staff") {

            $session_value = Session::get('Session_Value');

            $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
            $leave_data = DB::table('leave_data')->where(["approval_status" => "[APPROVED]"])->orWhere("approval_status", "[DECLINED]")->orderBy('date_of_request', 'DESC')->get();

            return view("staff-dashboard-content/my-leave-history")->with(["staff_basic_data" => $staff_basic_data, "leave_data" => $leave_data, "filter_options" => ["type_of_leave" => "All", "year" => "All", "month" => "All", "status" => "All"]]); //Send staff data with it.

        } else {

            return Redirect::to("/");
        }
    }

    public function FilterSearchLeaveHistoryPageOfStaffAccountController(Request $request)
    {
        $session_type = Session::get('Session_Type');

        if ($session_type == "Staff") {

            $session_value = Session::get('Session_Value');

            $staff_basic_data = DB::table('staff_data')->select("firstname", "lastname")->where(["staff_id" => $session_value])->get();
            $SqlCode = "";

            $type_of_leave =  $request->type_of_leave;
            $year          =  $request->year;
            $month         =  $request->month;
            $status        =  $request->status;


            if ($type_of_leave == "All" && $year == "All" && $month == "All" && $status == "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE approval_status  = '[ACCEPTED]' OR approval_status = '[DECLINED]' ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year == "All" && $month == "All" && $status == "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE type_of_leave = '$type_of_leave' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month == "All" && $status == "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '{$year}______%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month != "All" && $status == "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year == "All" && $month == "All" && $status != "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE approval_status = '$status' ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month == "All" && $status == "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month != "All" && $status == "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month != "All" && $status != "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE (from_date::text LIKE '%{$year}_{$month}___%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status') AND (approval_status = '[ACCEPTED]' OR approval_status = '[DECLINED]') ORDER BY from_date DESC";
            } else if ($type_of_leave != "All" && $year != "All" && $month == "All" && $status != "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND type_of_leave = '$type_of_leave' AND approval_status = '$status' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month == "All" && $status != "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}______%' AND approval_status = '$status' ORDER BY from_date DESC";
            } else if ($type_of_leave == "All" && $year != "All" && $month != "All" && $status != "All") {

                $SqlCode = "SELECT * FROM leave_data WHERE from_date::text LIKE '%{$year}_{$month}___%' AND approval_status = '$status' ORDER BY from_date DESC";
            } else {

                return redirect()->back()->withErrors("<strong>Wrong filter.</strong>");
            }

            $leave_data = DB::select($SqlCode); // SQL-CODE


            return view("staff-dashboard-content/my-leave-history")->with(["staff_basic_data" => $staff_basic_data, "leave_data" => $leave_data, "filter_options" => ["type_of_leave" => "$type_of_leave", "year" => "$year", "month" => "$month", "status" => "$status"]]); //Send staff data with it.


        } else {

            return Redirect::to("/");
        }
    }
    public function UploadFile(Request $request)
    {

        $proof = $request->file('proof');
        $input['filename'] = time() . '.' . $proof->getClientOriginalExtension();
        $destination_path = public_path('/files');
        $proof->move($destination_path, $input['filename']);
    }

    public function DownloadFile($file)
    {

        $url = Storage::url($file);
        $download = DB::table('leave_data')->get();
        return Storage::download($url);
    }

    public function ViewEventIndexController(Request $request)
    {

        // $Eventdata = DB::select("SELECT * FROM events");

        // $EventCounts = DB::select('SELECT COUNT(id) as count, event_id from eventsattendences GROUP BY  event_id  ' );
        // $session_id = Session::get('Session_Id');
        $EventData = DB::table('events')
            ->select('events.*', 'attendances.count as attendance_count', 'registrations.count as registration_count')
            ->leftJoinSub(function ($query) {
                $query->select('event_id', DB::raw('COUNT(*) as count'))
                    ->from('eventsattendences')
                    ->groupBy('event_id');
            }, 'attendances', 'events.id', '=', 'attendances.event_id')
            ->leftJoinSub(function ($query) {
                $query->select('event_id', DB::raw('COUNT(*) as count'))
                    ->from('registerevents')
                    ->groupBy('event_id');
            }, 'registrations', 'events.id', '=', 'registrations.event_id')
            ->get();



        $Item =  DB::select('SELECT event_name  from eventsapprovals  WHERE Approval_Status = ?', ["[APPROVED]"]);

        return view("mentor-dashboard-content/view-event-index")->with(["Event_Data" => $EventData, "Search_Item" => $Item]);
    }

    public function viewEventsController()
    {
        $session_id = Session::get('Session_Id');
        $currentDate = date('Y-m-d'); // Get the current date

        $nonMarkedEvents = DB::table('registerevents')
            ->where('to_date', '>=', $currentDate)
            ->where('user_id', $session_id) // Filter events for the specific user
            ->whereNotExists(function ($query) use ($session_id) {
                $query->select(DB::raw(1))
                    ->from('eventsattendences')
                    ->whereRaw('eventsattendences.event_id = registerevents.event_id')
                    ->where('eventsattendences.user_id', $session_id);
            })
            ->get();



        $nonRegisterEvents = DB::table('events')
            ->where('to_date', '>=', $currentDate) // Filter events that haven't ended yet
            ->whereNotIn('id', function ($query) use ($session_id) {
                $query->select('event_id')
                    ->from('registerevents')
                    ->where('user_id', $session_id);
            })
            ->get();




        return view("mentor-dashboard-content/view-events")->with(["Event_Data" => $nonMarkedEvents, "Event_Datas" => $nonRegisterEvents]);
    }


    public function ViewAttendanceLogController()
    {

        $Attendancelog = DB::select("SELECT * FROM leave_data");



        $StaffCounts = DB::select('SELECT COUNT(auto_id) as staff_count , date_of_request from leave_data  WHERE session = ? GROUP BY date_of_request', ["staff"]);

        $StudentCounts = DB::select('SELECT COUNT(auto_id) as student_count, date_of_request from leave_data WHERE session = ? GROUP BY date_of_request', ["student"]);



        return view("sadmin-dashboard-content/view-attendance-log")->with(['Attendance_Log' => $Attendancelog, 'Staff_Counts' => $StaffCounts, 'Student_Counts' => $StudentCounts]);
    }


    public function ViewStaffAttendancesController($date_of_request)
    {

        $staffdata = DB::select("SELECT * FROM leave_data WHERE date_of_request = ? AND session = ? ", [$date_of_request, "staff"]);


        return view("sadmin-dashboard-content/view-staff-attendances")->with(["staffdata" => $staffdata,  "date" => $date_of_request]);
    }

    public function ViewStudentAttendancesController($date_of_request)
    {

        $studentdata = DB::select("SELECT * FROM leave_data WHERE date_of_request = ? AND session = ? ", [$date_of_request, "student"]);

        return view("sadmin-dashboard-content/view-student-attendances")->with(["studentdata" => $studentdata, "date" => $date_of_request]);
    }


    public function ViewEventsApprovalController($id)
    {


        $EventRequest = DB::select("SELECT * FROM eventsapprovals WHERE User_Id = ?", [$id]);

        return view("mentor-dashboard-content.view-events-approval")->with(["Event_Request" => $EventRequest]);
    }

    public function ViewEventRequestController()
    {


        $eventrequest = DB::select("SELECT * FROM eventsapprovals WHERE Approval_Status = ? ", ['[PENDING]']);

        return view("sadmin-dashboard-content/view-event-request")->with(["Event_request" => $eventrequest]);
    }


    public function DeclineEventRequestController($id)
    {


        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            if (DB::table('eventsapprovals')->where('id', $id)->update(['Approval_Status' => "[DECLINED]"])) {

                return redirect()->back()->with('message', 'Declined');
            }
        }
    }
    public function AcceptEventRequestController($id)
    {


        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            if (DB::table('eventsapprovals')->where('id', $id)->update(['Approval_Status' => "[APPROVED]"])) {

                return redirect()->back()->with('message', 'Approved');
            }
        }
    }

    public function StorePhotoController(Request $request)
    {

        // $photoData = $request->photo_data;
        // $session_id = Session::get('Session_Id');

        // if ($photoData) {
        //     $decodedImage = base64_decode($photoData);
        //     $filename = 'captured_photo_' . $session_id . '.jpg';
        //     Storage::disk('public')->put($filename, $decodedImage);
        return redirect()->back()->with('message', 'Photo has been stored successfully');
    }

    //     return redirect()->back()->withErrors("Not Stored");
    // }



    public function ViewRegisterStudents($id)
    {

        $RegisterData = DB::table('registerevents')
            ->join('user_account', 'registerevents.user_id', '=', 'user_account.staff_id')
            ->where('registerevents.event_id', '=', $id)
            ->select('user_account.username')
            ->get();

        return view("mentor-dashboard-content/view-register-students")->with(["register_data" => $RegisterData]);
    }

    public function ViewStudentAttendances($id)
    {

        $RegisterData = DB::table('eventsattendences')
            ->join('user_account', 'eventsattendences.user_id', '=', 'user_account.staff_id')
            ->where('eventsattendences.event_id', '=', $id)
            ->select('user_account.username')
            ->get();

        return view("mentor-dashboard-content/view-student-attendances")->with(["register_data" => $RegisterData]);
    }
}
