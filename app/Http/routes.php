<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

// home
Route::get('/', 'HomeController@index');

// for tournaments
Route::post('/tournament/create', 'TournamentController@create');
Route::get('/tournament/play/{id}', 'TournamentController@play')
->where('id', '[0-9]+');

// lang
Route::get('/lang/change/{lang}', 'LangController@change')
->where('lang', '[a-z]{2}');