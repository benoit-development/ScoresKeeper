<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments = Tournament::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();
        
        return view('home', ['tournaments' => $tournaments]);
    }
}
