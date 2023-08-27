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
