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
Route::get('/', ['uses' => 'HomeController@index', 'as' => 'welcome']);

// for tournaments
Route::get('/tournament/home', ['uses' => 'TournamentController@home', 'as' => 'home']);
Route::post('/tournament/create', 'TournamentController@create');
Route::get('/tournament/play/{id}', ['uses' => 'TournamentController@play', 'as' => 'play'])
->where('id', '[0-9]+');
Route::post('/tournament/delete', ['uses' => 'TournamentController@delete', 'as' => 'delete']);
Route::get('/tournament/fetchAll', ['uses' => 'TournamentController@fetchAll', 'as' => 'fetchAll']);
Route::post('/tournament/addPlayer', 'TournamentController@addPlayer');

// lang
Route::get('/lang/change/{lang}', 'LangController@change')
->where('lang', '[a-z]{2}');