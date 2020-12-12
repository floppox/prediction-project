<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubMeetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_meet', function (Blueprint $table) {
            $table->unsignedTinyInteger('club_id');
            $table->unsignedTinyInteger('meet_id');
            $table->string('host_or_guest');
            $table->tinyInteger('score');
            $table->tinyInteger('missed_score');
            $table->tinyInteger('points');
            $table->string('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_meet');
    }
}
