<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayersScores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tournament_id');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->tinyInteger('order')->default(0);
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('players');
            $table->integer('tournament_id')->unsigned();
            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->integer('score')->unsigned();
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
        Schema::drop('players');
        Schema::drop('scores');
    }
}

