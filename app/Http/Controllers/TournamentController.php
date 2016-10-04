<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TournamentType;
use Illuminate\Support\Facades\Validator;

/**
 * Controller managing tournaments
 * 
 * @author Benoît BOUSQUET
 *
 */
class TournamentController extends Controller
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
        return view('home');
    }

    /**
     * Create new tournament and begin it
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|max:255',
            'type' => 'required|integer|in:' . implode(',', array_keys(TournamentType::LIST)),
        ]);
        
        if ($validator->fails()) {
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        return redirect('tournament/display/' . $id);
    }
}
