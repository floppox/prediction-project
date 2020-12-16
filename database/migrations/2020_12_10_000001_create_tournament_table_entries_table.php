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
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->tinyInteger('position')->nullable();
            $table->tinyInteger('played')->nullable();
            $table->tinyInteger('won')->nullable();
            $table->tinyInteger('drawn')->nullable();
            $table->tinyInteger('lost')->nullable();
            $table->tinyInteger('gf')->nullable();
            $table->tinyInteger('ga')->nullable();
            $table->tinyInteger('gd')->nullable();
            $table->tinyInteger('points')->nullable();
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
