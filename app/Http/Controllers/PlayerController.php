<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Tournament;
use App\Player;

/**
 * Controller managing players
 * 
 * @author Benoît BOUSQUET
 *
 */
class PlayerController extends Controller
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
     * Add a player to a tournament for ajax call (json response)
     * Updated details of the tournament is returned in response
     * 
     * @param Request $request
     */
    public function add(Request $request) {

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
            $tournament = Tournament::where(['id' => $request->tournament_id, 'user_id' => $user->id, 'archived' => false])->first();
            if (!($tournament instanceof Tournament)) {
                
                // user can't add player in this tournament (doesn't exists or doesn't own it)
                Log::debug("error wrong tournament id");
                $response['errors'] = 'wrong tournament id';
                $response['status'] = 'error';
                
            } else {
                
                // get current max order
                $currentMax = $tournament->getPlayersMaxOrder();
            
                // add player into database
                $player = new Player();
                $player->tournament_id = Input::get('tournament_id');
                $player->name = Input::get('name');
                $player->order = $currentMax + 1;
                $player->save();

                Log::debug("new player inserted");
                $response['status'] = 'success';
                $response['details'] = $tournament->getDetails();
                
            }
        }

        // return response
        return response()->json($response);
    }
    
    
    /**
     * Player delete for ajax call (json response)
     * 
     * @param Request $request
     */
    public function delete(Request $request) {
        Log::info('Deleting player');
        
        // validate data
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        
        $response = [];
        
        if ($validator->fails()) {
            
            Log::debug("error while deleting player : \nInputs : " . print_r($validator->getData(), true) . "\nErrors : " . print_r($validator->errors(), true));
            $response['status'] = 'error';
            
        } else {
        
            $user = Auth::user();

            // retrieve associated tournament
            $tournament = Tournament::where(['tournaments.user_id' => $user->id, 'tournaments.archived' => false])
            ->join('players', 'players.tournament_id', '=', 'tournaments.id')
            ->select('tournaments.*')
            ->first();
            
            if (!$tournament) {
            
                Log::debug("error while getting tournament data : \nInputs : " . print_r($validator->getData(), true) . "\nErrors : " . print_r($validator->errors(), true));
                $response['status'] = 'error';
                
            } else {
            
                $result = Player::where(['players.id' => $request->id])
                ->join('tournaments', 'players.tournament_id', '=', 'tournaments.id')
                ->where(['tournaments.user_id' => $user->id])
                ->delete();
                
                if ($result > 0) {
                    $response['status'] = 'success';
                    $response['details'] = $tournament->getDetails();
                } else {
                    $response['status'] = 'error';
                }
            }
            
        }
        
        return response()->json($response);
        
    }
    
    /**
     * Order players of a tournament
     * 
     * @param Request $request
     */
    public function order(Request $request) {

        // error messages
        $response = [];
        
        // validate data format
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|integer',
            'order' => 'required|numeric_array',
        ]);
        
        if ($validator->fails()) {
            Log::debug("error while adding player : \nInputs : " . print_r($validator->getData(), true) . "\nErrors : " . print_r($validator->errors(), true));
            $response['errors'] = $validator->errors();
            $response['status'] = 'error';
        } else {
            
        }
        
        return response()->json($response);
    }
}
