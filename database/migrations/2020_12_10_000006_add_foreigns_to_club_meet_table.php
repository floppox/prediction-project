<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToClubMeetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_meet', function (Blueprint $table) {
            $table
                ->foreign('club_id')
                ->references('id')
                ->on('clubs')
                ->onDelete('cascade');
            $table
                ->foreign('meet_id')
                ->references('id')
                ->on('meets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_meet', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropForeign(['meet_id']);
        });
    }
}
