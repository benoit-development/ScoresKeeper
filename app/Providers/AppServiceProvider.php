<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // validator for numeric array
        Validator::extend('numeric_array', 'App\Validators\NumericArray@validate');
        Validator::extend('own_player_list', 'App\Validators\OwnPlayerList@validate');
        Validator::extend('player_list_same_tournament', 'App\Validators\PlayerListSameTournament@validate');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
