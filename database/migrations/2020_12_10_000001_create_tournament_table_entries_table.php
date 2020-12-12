<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentTableEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_table_entries', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('club_id');
            $table->tinyInteger('position');
            $table->tinyInteger('played');
            $table->tinyInteger('won');
            $table->tinyInteger('drawn');
            $table->tinyInteger('lost');
            $table->tinyInteger('gf');
            $table->tinyInteger('ga');
            $table->tinyInteger('gd');
            $table->tinyInteger('points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament_table_entries');
    }
}
