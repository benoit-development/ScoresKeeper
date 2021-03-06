<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('label', 255);
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('tournaments_type');
            $table->timestamps();
        });

        Schema::create('tournament_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 255);
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
        Schema::drop('tournaments');
        Schema::drop('tournament_types');
    }
}