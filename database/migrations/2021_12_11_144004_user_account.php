<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_account', function (Blueprint $table) {

        $table->increments('auto_id');
        $table->string('staff_id');
        $table->string('username');
        $table->string('password');
        $table->string('account_type');
        $table->string('image')->nullable();
      });

      // Insert some staff
      DB::table('user_account')->insert(
         array(
             'staff_id' => "00001",
             'username' => "keerthi",
             'password' => "keerthi123",
             'account_type' => "sadmin",
         )
      );
      DB::table('user_account')->insert(
        array(
            'staff_id' => "00002",
            'username' => "hari",
            'password' => "hari123",
            'account_type' => "staff",
        )
     );
     DB::table('user_account')->insert(
        array(
            'staff_id' => "00003",
            'username' => "guru",
            'password' => "guru123",
            'account_type' => "student",
        )
     );
     DB::table('user_account')->insert(
        array(
            'staff_id' => "00004",
            'username' => "sai",
            'password' => "sai123",
            'account_type' => "student",
        )
     );
     DB::table('user_account')->insert(
        array(
            'staff_id' => "00005",
            'username' => "kavin",
            'password' => "kavin123",
            'account_type' => "staff",
        )
     );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
