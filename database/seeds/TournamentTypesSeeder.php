<?php

class TournamentTypesSeeder extends Seeder {

    public function run()
    {
        DB::table('tournament_types')->delete();

        User::create(['email' => 'foo@bar.com']);
    }

}