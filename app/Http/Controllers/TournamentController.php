<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Tournament;
use App\TournamentType;
use App\Player;

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
    public function fetchAll()
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
            'type' => 'required|integer|in:' . implode(',', array_keys(TournamentType::TYPE_LIST)),
        ]);
        
        // response to be returned in JSON
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
     * Play an existing tournament to play it
     *
     * @return \Illuminate\Http\Response
     */
    public function play(Request $request)
    {
        Log::info('Playing tournament');
        
        $user = Auth::user();
        $tournament = Tournament::where(['id' => $request->id, 'user_id' => $user->id])->first();
        
        if (!($tournament instanceof Tournament)) {
            abort(404, 'Tournament not found');
        }
        
        return view('tournament.play', ['tournament' => $tournament, 'details' => $tournament->getDetails()]);
    }
    
    
    /**
     * Tournment deletion for ajax call (json response)
     * 
     * @param Request $request
     */
    public function delete(Request $request) {
        Log::info('Deleting tournament');
        
        $user = Auth::user();
        $result = Tournament::where(['id' => $request->id, 'user_id' => $user->id])->delete();
        
        return response()->json((($result > 0)?'success':'error'));
    }
    
    
    /**
     * Add a player to a tournament for ajax call (json response)
     * Updated details of the tournament is returned in response
     * 
     * @param Request $request
     */
    public function addPlayer(Request $request) {

        // error messages
        $response = [];
        
        // validate data format
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|integer',
            'name' => 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            Log::debug("error while adding player : \nInputs : " . print_r($validator->getData(), true) . "\nErrors : " . print_r($validator->errors(), true));
            $response['errors'] = $validator->errors();
            $response['status'] = 'error';
        } else {
            
            // validate tournament id
            $user = Auth::user();
            $tournament = Tournament::where(['id' => $request->tournament_id, 'user_id' => $user->id])->first();
            if (!($tournament instanceof Tournament)) {
                
                // user can't add player in this tournament (doesn't exists or doesn't own it)
                Log::debug("error wrong tournament id");
                $response['errors'] = 'wrong tournament id';
                $response['status'] = 'error';
                
            } else {
            
                // add player into database
                $player = new Player();
                $player->tournament_id = Input::get('tournament_id');
                $player->name = Input::get('name');
                $player->save();

                Log::debug("new player inserted");
                $response['status'] = 'success';
                $response['details'] = $tournament->getDetails();
                
            }
        }

        // return response
        return response()->json($response);
    }
}
