<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsapprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventsapprovals', function (Blueprint $table) {
            $table->id();
            $table->string("event_name");
            $table->string("event_venue");
            $table->date("F_date");
            $table->date("T_date");
            $table->string("User_Id");
            $table->string("User_Name");
            $table->string("Approval_Status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventsapprovals');
    }
}
