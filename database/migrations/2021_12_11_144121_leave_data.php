<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeaveData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('leave_data', function (Blueprint $table) {

        $table->increments('auto_id');
        $table->string('staff_id');
        // $table->string('type_of_leave');
        // $table->string('description',5000);
        // $table->date('from_date');
        // $table->date('to_date');
        $table->string('session');
        // $table->string('proof');
        $table->date('date_of_request');
        $table->string('request_time');
        // $table->string('approval_status');
        $table->string('updated_at')->nullable();
        $table->string('created_at')->nullable();

      });



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
