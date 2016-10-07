<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TournamentType;
use Illuminate\Support\Facades\Validator;
use App\Tournament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
     * Show the application dashboard as home
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $tournaments = Tournament::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->get();
        
        return view('tournament.home', ['tournaments' => $tournaments]);
    }

    /**
     * Create new tournament and begin it
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Log::info('Tournament creation requested');
        
        $validator = Validator::make($request->all(), [
            'label' => 'required|max:255',
            'type' => 'required|integer|in:' . implode(',', array_keys(TournamentType::LIST)),
        ]);
        
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }
        
        Log::debug("Tournament creation data : \nUser id : " . Auth::user()->id . "\nLabel : $request->label\nType : $request->type");
        
        $tournament = new Tournament();
        $tournament->user_id = Auth::user()->id;
        $tournament->label = $request->label;
        $tournament->type_id = $request->type;
        $tournament->save();
        
        return redirect('tournament/play/' . $tournament->id);
    }
    


    /**
     * Display an existing tournament to play it
     *
     * @return \Illuminate\Http\Response
     */
    public function play(Request $request)
    {
        $user = Auth::user();
        $tournament = Tournament::where(['id' => $request->id, 'user_id' => $user->id])->first();
        
        if (!isset($tournament)) {
            abort(404, 'Tournament not found');
        }
        
        return view('tournament.display', ['tournament' => $tournament]);
    }
}
