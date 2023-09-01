<?php

namespace App\Http\Controllers;

use data;
use Exception;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\leave_data;
use Intervention\Image\Facades\Image;
use GuzzleHttp\Client;



class DatabaseController extends Controller
{
    public function InsertStaffData(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $validatedata = $request->validate([
                'staff_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:10',
                'image' => 'required'
                //   'position' => 'required',
            ]);

            $staff_id = $request->staff_id;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $date_of_birth = $request->date_of_birth;
            $email = $request->email;
            $phone_number = $request->phone_number;
            // $position       = $request->position;

            // Rename the uploaded file to the student ID
            $uploadedFile = $request->file('image');
            $originalFilename = $uploadedFile->getClientOriginalName();
            $extension = $uploadedFile->getClientOriginalExtension();
            $newFilename = $staff_id . '.' . $extension;

            // Store the file with the new filename


            if (DB::table('staff_data')->where('staff_id', $staff_id)->doesntExist()) {

                if (DB::insert('INSERT INTO staff_data (staff_id, firstname, lastname, dob, email, phone_number) values (?, ?, ?, ?, ?, ?)', [$staff_id, $first_name, $last_name, $date_of_birth, $email, $phone_number])) {

                    if ($imagePath = $uploadedFile->storeAs('student_images', $newFilename, 'public')) {
                        return redirect()->back()->with('message', 'Registeration is Successful.');
                    }


                }
            } else {
                return redirect()->back()->withErrors("<strong>Unable to register:</strong> The given staff ID already exists in the database");
            }
        }
    }

    public function DeleteStaffData($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            if (DB::table('staff_data')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function UpdateStaffData(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            $validatedata = $request->validate([
                'auto_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:10',
                //   'position' => 'required',
            ]);

            $auto_id = $request->auto_id;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $date_of_birth = $request->date_of_birth;
            $email = $request->email;
            $phone_number = $request->phone_number;
            // $position       = $request->position;


            if (DB::table('staff_data')->where('auto_id', $auto_id)->update(['firstname' => $first_name, 'lastname' => $last_name, 'dob' => $date_of_birth, 'email' => $email, 'phone_number' => $phone_number])) {

                return Redirect::to("/view-staff-management-index")->with('message', 'Updation is Successful.');
            } else {

                return Redirect::to("/view-staff-management-index")->with('message', 'No changes made.');
            }
        } else {

            return Redirect::to("/");
        }
    }


    public function ChangeUsername(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            $admin_data = DB::table('user_account')->where("account_type", "sadmin")->get(); // Get staff data.

            if ($request->password == $admin_data[0]->password) {

                if (DB::table('user_account')->where('account_type', 'sadmin')->update(['username' => $request->username])) {

                    return redirect()->back()->with('message', 'Username has been updated successfully.');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return redirect()->back()->withErrors('The password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangePassword(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {

            $admin_data = DB::table('user_account')->where("account_type", "sadmin")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'sadmin')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else if ($session_type == "mentor") {

            $admin_data = DB::table('user_account')->where("account_type", "mentor")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'mentor')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else if ($session_type == "slincharge") {

            $admin_data = DB::table('user_account')->where("account_type", "slincharge")->get(); // Get staff data.

            if ($request->current_password == $admin_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where('account_type', 'slincharge')->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else if ($session_type == "slhead") {

                $admin_data = DB::table('user_account')->where("account_type", "slhead")->get(); // Get staff data.

                if ($request->current_password == $admin_data[0]->password) {

                    if ($request->new_password == $request->confirm_password) {

                        if (DB::table('user_account')->where('account_type', 'slhead')->update(['password' => $request->new_password])) {

                            return redirect()->back()->with('message', 'Password has been updated successfully.');
                        } else {

                            return redirect()->back()->with('message', 'No changes made.');
                        }
                    } else {

                        return redirect()->back()->withErrors('The confirm password does not match');
                    }
                } else {

                    return redirect()->back()->withErrors('The current password is wrong.');
                }
            } else if ($session_type == "sadmin") {

                $admin_data = DB::table('user_account')->where("account_type", "sadmin")->get(); // Get staff data.

                if ($request->current_password == $admin_data[0]->password) {

                    if ($request->new_password == $request->confirm_password) {

                        if (DB::table('user_account')->where('account_type', 'sadmin')->update(['password' => $request->new_password])) {

                            return redirect()->back()->with('message', 'Password has been updated successfully.');
                        } else {

                            return redirect()->back()->with('message', 'No changes made.');
                        }
                    } else {

                        return redirect()->back()->withErrors('The confirm password does not match');
                    }
                } else {

                    return redirect()->back()->withErrors('The current password is wrong.');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function EditUserAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "sadmin") {


            $validatedata = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);


            $username = $request->username;
            $password = $request->password;
            $auto_id = $request->auto_id;

            if (DB::table('user_account')->where('auto_id', $auto_id)->update(['username' => $username, 'password' => $password])) {

                return Redirect::to("/view-user-accounts-index")->with('message', 'Updation is Successful.');
            } else {

                return Redirect::to("/view-user-accounts-index")->with('message', 'No changes made.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function DeleteUserAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Admin") {

            if (DB::table('user_account')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function InsertUserAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "sadmin") {

            $validatedata = $request->validate([
                'staff_id' => 'required',
                'username' => 'required',
                'password' => 'required',
                'acc_type' => 'required',
            ]);

            $staff_id = $request->staff_id;
            $username = $request->username;
            $password = $request->password;
            $acc_type = $request->acc_type;
            $image = $request->photoStore;


            $imageData = base64_decode($image);

            $uploadimage = Image::make($imageData);

            $filename = $staff_id . '.png';

            if ($uploadimage->save(storage_path('/app/public/student_images/' . $filename))) {

                if (DB::table('user_account')->where('staff_id', $staff_id)->doesntExist()) {

                    if (DB::table('user_account')->where('username', $username)->doesntExist()) {

                        if (DB::insert('INSERT INTO user_account (staff_id, username, password, account_type, image) values (?, ?, ?, ?, ?)', [$staff_id, $username, $password, $acc_type, $filename])) {
                            return redirect()->back()->with('message', 'Account creation is Successful.');
                        }
                    } else {

                        return redirect()->back()->withErrors("<strong>Unable to create:</strong> The given username already exists in the database.");
                    }
                } else {

                    return redirect()->back()->withErrors("<strong>Unable to create:</strong> The staff already has an account");
                }
            }
        }
    }

    // public function AcceptRequest($auto_id)
    // {

    //     $session_type = Session::get('Session_Type');
    //     $session_value = Session::get('Session_Value');

    //     if ($session_type == "mentor") {

    //         $leave_type_check = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();

    //         $leave_type_final = $leave_type_check[0]->type_of_leave;

    //         if ($leave_type_final == 'Sick leave' or $leave_type_final == 'Casual leave') {
    //             if ($this->isOnline()) {

    //                 $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
    //                 $staffid = $leavedata[0]->staff_id;
    //                 $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
    //                 $mailid = $staffdata[0]->email;
    //                 //return $mailid;
    //                 $data = [

    //                     "recipient" => $mailid,
    //                     "fromemail" => "camps@bitsathy.ac.in",
    //                     "fromname" => "Camps Site",
    //                     "subject" => 'Reg: Leave request',
    //                     "body" => '           Your leave request has been accepted'

    //                 ];
    //                 try {
    //                     Mail::to($mailid)->send(new MailNotify($data));
    //                 } catch (Exception $th) {
    //                     return $th;
    //                 }

    //                 if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[APPROVED]"])) {
    //                     return redirect()->back()->with('message', 'Accepted');
    //                 } else {

    //                     return redirect()->back()->with('message', 'No changes made.');
    //                 }
    //             } else {

    //                 return "No Internet Connection";
    //             }
    //             if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[APPROVED]"])) {
    //                 return redirect()->back()->with('message', 'Accepted');
    //             } else {
    //                 return redirect()->back()->with('message', 'No changes made.');
    //             }
    //         } else {
    //             if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[MENTOR APPROVED]"])) {
    //                 return redirect()->back()->with('message', 'Accepted');
    //             } else {

    //                 return redirect()->back()->with('message', 'No changes made.');
    //             }
    //         }
    //     } else if ($session_type == 'slincharge') {

    //         if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[SLINC APPROVED]"])) {
    //             return redirect()->back()->with('message', 'Accepted');
    //         } else {

    //             return redirect()->back()->with('message', 'No changes made.');
    //         }
    //     } else if ($session_type == 'slhead') {

    //         if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[SLHEAD APPROVED]"])) {
    //             return redirect()->back()->with('message', 'Accepted');
    //         } else {

    //             return redirect()->back()->with('message', 'No changes made.');
    //         }
    //     } else if ($session_type == 'Admin') {

    //         if ($this->isOnline()) {

    //             $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
    //             $staffid = $leavedata[0]->staff_id;
    //             $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
    //             $mailid = $staffdata[0]->email;
    //             //return $mailid;
    //             $data = [

    //                 "recipient" => $mailid,
    //                 "fromemail" => "camps@bitsathy.ac.in",
    //                 "fromname" => "Camps Site",
    //                 "subject" => 'Reg: Leave request',
    //                 "body" => '            Your OD request has been accepted'

    //             ];
    //             try {
    //                 Mail::to($mailid)->send(new MailNotify($data));
    //             } catch (Exception $th) {
    //                 return $th;
    //             }

    //             if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[APPROVED]"])) {
    //                 return redirect()->back()->with('message', 'Accepted');
    //             } else {

    //                 return redirect()->back()->with('message', 'No changes made.');
    //             }
    //         } else {

    //             return "No Internet Connection";
    //         }
    //     } else {
    //         return Redirect::to("/");
    //     }
    // }

    //  public function sendEmail(){

    //     if($this->isOnline()){

    //         $leavedata = DB::table('leave_data')->where(['auto_id'=> $auto_id])->get();
    //         $staffid = $leavedata[0]->staff_id;
    //         $staffdata=DB::table('staff_data')->where(['staff_id'=> $staffid])->get();
    //         $mailid= $staffdata[0]->email;
    //         //return $mailid;
    //          $data1=[

    //              "recipient"=> "kavinraj.cs21@bitsathy.ac.in",
    //              "fromemail"=>"srisathyasai24680@gmail.com",
    //              "fromname"=> "Camps Site",
    //              "subject" => 'Reg: Leave request',
    //              "body"=> 'Your leave request as been accepted'

    //          ];
    //          try {
    //              Mail::to("srisathyasai24680@gmail.com")->send(new MailNotify($data1));
    //          } catch (Exception $th) {
    //              return 'mail not sent';
    //          }

    //      }else{
    //          return "No internet connection";
    //      }

    //  }

    public function isOnline($site = "https://youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }

    public function DeclineRequest($auto_id)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Admin") {

            if ($this->isOnline()) {

                $leavedata = DB::table('leave_data')->where(['auto_id' => $auto_id])->get();
                $staffid = $leavedata[0]->staff_id;
                $staffdata = DB::table('staff_data')->where(['staff_id' => $staffid])->get();
                $mailid = $staffdata[0]->email;
                //return $mailid;
                $data = [

                    "recipient" => $mailid,
                    "fromemail" => "srisathyasai24680@gmail.com",
                    "fromname" => "Camps Site",
                    "subject" => 'Reg: Leave request',
                    "body" => '         Your leave/OD request has been declined'

                ];
                try {
                    Mail::to($mailid)->send(new MailNotify($data));
                } catch (Exception $th) {
                    return 'mail not sent';
                }
                if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                    return redirect()->back()->with('message', 'Declined');
                } else {

                    return Redirect::to("/");
                }
            } else {
                return "No internet connection";
            }
        } else if ($session_type == 'mentor') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return Redirect::to("/");
            }
        } else if ($session_type == 'slincharge') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return Redirect::to("/");
            }
        } else if ($session_type == 'slhead') {

            if (DB::table('leave_data')->where(["auto_id" => $auto_id])->update(['approval_status' => "[DECLINED]"])) {
                return redirect()->back()->with('message', 'Declined');
            } else {

                return Redirect::to("/");
            }
        } else {
            return redirect()->back()->with('message', 'No changes made.');
        }
    }

    public function ChangeUsernameOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Staff") {

            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            if ($request->password == $staff_data[0]->password) {

                if (DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->update(['username' => $request->username])) {

                    return redirect()->back()->with('message', 'Username has been updated successfully.');
                } else {

                    return redirect()->back()->with('message', 'No changes made.');
                }
            } else {

                return redirect()->back()->withErrors('The password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function ChangePasswordOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "Staff") {

            $staff_data = DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->get(); // Get staff data.

            if ($request->current_password == $staff_data[0]->password) {

                if ($request->new_password == $request->confirm_password) {

                    if (DB::table('user_account')->where(["account_type" => "staff", "staff_id" => $session_value])->update(['password' => $request->new_password])) {

                        return redirect()->back()->with('message', 'Password has been updated successfully.');
                    } else {

                        return redirect()->back()->with('message', 'No changes made.');
                    }
                } else {

                    return redirect()->back()->withErrors('The confirm password does not match');
                }
            } else {

                return redirect()->back()->withErrors('The current password is wrong.');
            }
        } else {

            return Redirect::to("/");
        }
    }


    public function InsertLeaveDataOfStaffAccount(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        $currentTime = now();
        $Time = now()->format('h:i A');

        // Define the two time ranges
        $timeRange1Start = now()->setTime(8, 0, 0); // 8:00 AM
        $timeRange1End = now()->setTime(11, 45, 0); // 8:45 AM
        $timeRange2Start = now()->setTime(12, 0, 0); // 12:30 PM
        $timeRange2End = now()->setTime(24, 30, 0);
        // $timeRange3Start = now()->setTime(19, 0, 0);  // 12:30 PM
        // $timeRange3End = now()->setTime(20, 0, 0);    // 1:30 PM


        if (
            ($currentTime >= $timeRange1Start && $currentTime <= $timeRange1End) ||
            ($currentTime >= $timeRange2Start && $currentTime <= $timeRange2End)
            // ($currentTime >= $timeRange3Start && $currentTime <= $timeRange3End)
        ) {

            if ($session_type == "staff" || $session_type == "student") {

                $staff_id = $session_value;
                $date_of_request = date('Y-m-d');
                $request_time = $Time;
                // $session_type = $session_type;
                $userIp = $request->ip();

                $image2 = $request->photoStore;

                $imageData = base64_decode($image2);

                $markedimage = Image::make($imageData);

                $filename = uniqid() . '.png';

                $markedimage->save(storage_path('/app/public/markedimages/' . $filename));
                $sessionimage = Session::get('Session_image');
                $imagepath1 = storage_path('/app/public/student_images/'. $sessionimage);
                $imagepath2 = storage_path('/app/public/markedimages/' . $filename);

                $data1 = [
                    [
                        'name' => 'image1',
                        'contents' => file_get_contents($imagepath1),
                        'filename' => 'image1.png' // Adjust the filename as needed
                    ],
                    [
                        'name' => 'image2',
                        'contents' => file_get_contents($imagepath2),
                        'filename' => 'image2.png' // Adjust the filename as needed
                    ]
                ];

                $flaskServerUrl = 'http://localhost:5000/compare';
                $client = new Client();
                $response = $client->post($flaskServerUrl, [
                    'multipart' => $data1
                ]);

                $data = json_decode($response->getBody(), true);

                File::delete($imagepath2);
                if (isset($data['result'])) {
                    if ($data['result'] === "nofaces") {
                        return redirect()->back()->withErrors("No Face Detected");
                    } else {
                        if ($data['result'] === "same") {
                            if (DB::insert("INSERT INTO leave_data (staff_id, date_of_request ,session ,request_time ) values (?,? ,?, ?)", [$staff_id, $date_of_request, $session_type, $request_time])) {
                                return redirect()->back()->with('message', $userIp);
                            }
                        } else if($data['result'] === "notclear"){
                            return redirect()->back()->withErrors("Photo not clear");
                        }
                        else{
                            return redirect()->back()->withErrors("Face Did not match");
                        }
                    }
                } else {
                    return redirect()->back()->withErrors("Some Internal Error");
                }


                if (DB::insert("INSERT INTO leave_data (staff_id, date_of_request ,session ,request_time ) values (?,? ,?, ?)", [$staff_id, $date_of_request, $session_type, $request_time])) {
                    return redirect()->back()->with('message', $userIp);
                }
            }
        } else {

            return redirect()->back()->withErrors('Attendance marking is only allowed during specified time ranges.');
        }
    }

    public function DeleteLeavePendingRequestInStaffAccount($auto_id)
    {

        $session_type = Session::get('Session_Type');

        if ($session_type == "Staff") {

            if (DB::table('leave_data')->where('auto_id', '=', $auto_id)->delete()) {

                return redirect()->back()->with('message', 'Deletion is Successful.');
            }
        } else {

            return Redirect::to("/");
        }
    }

    public function Event(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');

        if ($session_type == "staff") {

            $validatedata = $request->validate([
                'eventname' => 'required',
                'fromdate' => 'required',
                'todate' => 'required',
                'venue' => 'required'
            ]);

            $eventname = $request->eventname;
            $fromdate = $request->fromdate;
            $todate = $request->todate;
            $venue = $request->venue;





            if (DB::insert('INSERT INTO events ( event_name, from_date, to_date, venue) values (?, ?, ?, ?)', [$eventname, $fromdate, $todate, $venue])) {

                return redirect()->back()->with('message', 'Event creation is Successful.');
            }
        } else {

            return redirect()->back()->withErrors("<strong>Unable to create:</strong>");
        }
    }



    public function InsertEventAttendance($id)
    {
        $session_type = Session::get('Session_Type');


        $session_id = Session::get('Session_Id');


        $Eventid = DB::table('events')->where('id', $id)->value('id');
        $Eventname = DB::table('events')->where('id', $id)->value('event_name');
        $From_date = DB::table('events')->where('id', $id)->value('from_date');
        $To_date = DB::table('events')->where('id', $id)->value('to_date');
        $Venue = DB::table('events')->where('id', $id)->value('venue');


        if ($session_type == "student") {



            $S_id = $session_id;
            $eventid = $Eventid;
            $eventname = $Eventname;
            $fromdate = $From_date;
            $todate = $To_date;
            $venue = $Venue;


            if (DB::insert("INSERT INTO eventsattendences (user_id,event_id,event_name,from_date,to_date,venue) values (?,?,?,?,?,?)", [$S_id,$eventid, $eventname, $fromdate, $todate, $venue])) {

                return redirect()->back()->with('message', 'Event attendence has Been marked');

            }
        }

    }



    public function EventApproval(Request $request)
    {

        $session_type = Session::get('Session_Type');
        $session_value = Session::get('Session_Value');
        $session_id = Session::get('Session_Id');

        if ($session_type == "staff") {

            $validatedata = $request->validate([
                'eventname' => 'required',
                'fdate' => 'required',
                'tdate' => 'required',
                'venue' => 'required',
                'venuename' => 'required'
            ]);

            $eventname = $request->eventname;
            $fdate = $request->fdate;
            $tdate = $request->tdate;
            $venue = $request->venue;
            $venuename = $request->venuename;
            $userid = $session_id;
            $username = $session_value;
            $approval_status = "[PENDING]";


            if ($eventname != 'NILL' && DB::insert('INSERT INTO eventsapprovals ( event_name , F_date,T_date, event_venue ,User_Id , User_Name ,Approval_Status) values (?, ? , ? , ? , ? , ? , ?)', [$eventname, $fdate, $tdate, $venue, $userid, $username, $approval_status])) {

                if ($venuename != 'NILL') {

                    DB::insert('INSERT INTO venueapprovals ( venue_name,User_Id , User_Name ,Approval_Status) values (?,? , ?,?)', [$venuename, $userid, $username, $approval_status]);
                }

                return redirect()->back()->with('message', 'Event creation is Successful.');

            } elseif ($venuename != 'NILL' && DB::insert('INSERT INTO venueapprovals ( venue_name , User_Id,User_Name,Approval_Status) values (? ,?, ? , ?)', [$venuename, $userid, $username, $approval_status])) {

                return redirect()->back()->with('message', 'Event creation is Successful.');

            } else {

                return redirect()->back()->with('message', 'Event creation is Successful.');

            }
        }
    }



    public function hi(Request $request)
    {
        $image2 = $request->photoStore;

        $imageData = base64_decode($image2);

        $markedimage = Image::make($imageData);

        $filename = uniqid() . '.png';

        $markedimage->save(storage_path('/app/public/markedimages/' . $filename));

        $imagepath1 = storage_path('/app/public/student_images/64eebf8028876.png');
        $imagepath2 = storage_path('/app/public/markedimages/' . $filename);

        $data1 = [
            [
                'name' => 'image1',
                'contents' => file_get_contents($imagepath1),
                'filename' => 'image1.png' // Adjust the filename as needed
            ],
            [
                'name' => 'image2',
                'contents' => file_get_contents($imagepath2),
                'filename' => 'image2.png' // Adjust the filename as needed
            ]
        ];
        $flaskServerUrl = 'http://localhost:5000/compare';
        $client = new Client();
        $response = $client->post($flaskServerUrl, [
            'multipart' => $data1
        ]);

        $data = json_decode($response->getBody(), true);

        File::delete($imagepath2);
        if (isset($data['result'])) {
            if ($data['result'] === "NoFaces") {
                return view('email.email')->with(["imgdata" => "No Faces Detected"]);
            } else {
                if ($data['result'] === "same") {
                    return view('email.email')->with(["imgdata" => "success"]);
                } else {
                    return view('email.email')->with(["imgdata" => "failure"]);
                }
            }
        } else {
            return view('email.email')->with(["imgdata" => "Error"]);
        }
    }

    public function RegisterEvent($id){

        $session_type = Session::get('Session_Type');
        // $session_value = Session::get('Session_Value');
        $session_id = Session::get('Session_Id');
        $id = $id;
        $Eventid = DB::table('events')->where('id', $id)->value('id');
        $Eventname = DB::table('events')->where('id', $id)->value('event_name');
        $From_date = DB::table('events')->where('id', $id)->value('from_date');
        $To_date = DB::table('events')->where('id', $id)->value('to_date');
        $Venue = DB::table('events')->where('id', $id)->value('venue');


        if ($session_type == "student") {



            $S_id = $session_id;
            $eventid = $Eventid;
            $eventname = $Eventname;
            $fromdate = $From_date;
            $todate = $To_date;
            $venue = $Venue;


            // if (DB::insert('INSERT INTO leave_data (staff_id, type_of_leave, description, from_date, to_date, session,proof,  date_of_request, approval_status ) values (?, ?, ?, ?, ?, ?,?,?,?)', [$staff_id, $type_of_leave, $description, $from_date, $to_date, $session, $proof, $date_of_request, $approval_status])) {

            //     return redirect()->back()->with('message', 'Leave request has been submited successfully.');
            // }

            if (DB::insert("INSERT INTO registerevents (user_id,event_id,event_name,from_date,to_date,venue) values (?,?,?,?,?,?)", [$S_id,$eventid, $eventname, $fromdate, $todate, $venue])) {
                return redirect()->back()->with('message', 'Event Has Been Registered');
            }
        }




}

}
