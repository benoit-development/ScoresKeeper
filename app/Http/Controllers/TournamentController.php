<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TournamentType;
use Illuminate\Support\Facades\Validator;
use App\Tournament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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
        return view('tournament.home');
    }
    
    /**
     * Retrieve in json a pagined list of user's tournaments
     * 
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $tournaments = Tournament::getPaginatedList();

        return response()->json($tournaments);
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
        
        $response = [];

        if ($validator->fails()) {

            Log::debug("error while creatin tournament : \nInputs : " . print_r($validator->getData(), true) . "\nErrors : " . print_r($validator->errors(), true));
            $response['errors'] = $validator->errors();
            $response['status'] = 'error';
            
        } else {
        
            $label = Input::get('label');
            $type = Input::get('type');
            $userId = Auth::user()->id;
            
            Log::debug("Tournament creation data : \nUser id : " . $userId . "\nLabel : $label\nType : $type");
            
            $tournament = new Tournament();
            $tournament->user_id = $userId;
            $tournament->label = $label;
            $tournament->type_id = $type;
            $tournament->save();

            $response['status'] = 'success';
            $response['id'] = $tournament->id;
        }
        
        return response()->json($response);
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
