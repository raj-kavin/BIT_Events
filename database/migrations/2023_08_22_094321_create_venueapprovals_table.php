<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueapprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venueapprovals', function (Blueprint $table) {
            $table->id();
            $table->string('venue_name');
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
        Schema::dropIfExists('venueapprovals');
    }
}
