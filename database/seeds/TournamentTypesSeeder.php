<?php

use Illuminate\Database\Seeder;

class TournamentTypesSeeder extends Seeder {

    public function run()
    {
        DB::table('tournament_types')->delete();
        DB::table('tournament_types')->insert([
            'id' => '1',
            'label' => 'card',
        ]);
    }

}