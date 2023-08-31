<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller
{
    public function HandleLoginContoller(Request $request){

        $this->validate($request, [
          'username' => 'required',
          'password' => 'required',
         // 'login_type' => 'required',
        ]);

        $user_entered_username    =    $request->username;
        $user_entered_password    =    $request->password;
       // $user_entered_login_type  =    $request->login_type;


        $real_staff_id      = "";
        $real_username      = "";
        $real_password      = "";
        $real_account_type  = "";
        $real_image         = "";

        $user = DB::select( DB::raw("SELECT staff_id,username, password,account_type,image FROM user_account WHERE username ='$user_entered_username'"));

        foreach($user as $u){

           $real_staff_id     =     $u->staff_id;
           $real_username     =     $u->username;
           $real_password     =     $u->password;
           $real_account_type =     $u->account_type;
           $real_image        =     $u->image;
       }

       if($real_username != "" && $real_password != "" && $real_account_type != ""){


         if($user_entered_username == $real_username && $user_entered_password == $real_password){

           if($real_account_type == "sadmin"){

             Session::put('Session_Type', 'sadmin');
             Session::put('Session_Value', $real_username);
            //  Session::put('Session_Id', $real_staff_id);

             return Redirect::to("/view-staff-management-index");
           }
          //  }else if($real_account_type == "staff"){

          //    Session::put('Session_Type', 'Staff');
          //    Session::put('Session_Value', $real_staff_id);

          //    return Redirect::to("/view-home-page-of-staff-account");


          //  }else if($real_account_type == "sadmin"){

          //   Session::put('Session_Type', 'sadmin');
          //   Session::put('Session_Value', $real_username);

          //   return Redirect::to("/view-staff-management-index");


          // }else if(str_contains($real_account_type, 'mentor')){

          //   Session::put('Session_Type', 'mentor');
          //   Session::put('Session_Value', $real_username);

          //   return Redirect::to("/view-home-page");


          // }
          else if($real_account_type == "staff"){

            Session::put('Session_Type', 'staff');
            Session::put('Session_Value', $real_username);
            Session::put('Session_Id', $real_staff_id);
            Session::put('Session_image', $real_image);


            return Redirect::to("/view-home-page");

          }
          else if($real_account_type == "student"){

            Session::put('Session_Type', 'student');
            Session::put('Session_Value', $real_username);
            Session::put('Session_Id', $real_staff_id);
            Session::put('Session_image', $real_image);
            
            return Redirect::to("/view-home-page");

          // }

        }else{

          return Redirect::to("/")->withErrors(['The username or password is incorrect.']);

        }



       }else{

         return Redirect::to("/")->withErrors(['Sorry, no account found for this credentials']);
       }

       echo $real_password." ".$real_password." ".$real_account_type;
    }
  }
    public function HandleLogoutContoller(){

      Session::flush();
      return Redirect('/');

    }


}
