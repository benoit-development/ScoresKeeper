<?php

namespace App\Validators;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Player;

/**
 * Validator checking if an array only has numeric values
 * 
 * @author Benoit BOUSQUET
 *
 */
class OwnPlayerList {
    
    /**
     * Validation of the value
     * 
     * @param unknown $attribute
     * @param unknown $values
     * @param unknown $parameters
     * @return boolean
     */
    public function validate($attribute, $values, $parameters)
    {
        // value must be an array
        if(! is_array($values)) {
            return false;
        }
    
        // check if an user is authenticated
        if (!Auth::check()) {
            return false;
        }
        
        // check if user own players
        $userId = Auth::user()->id;
        $nb = Player::whereIn('players.id', $values)
        ->join('tournaments', 'players.tournament_id', '=', 'tournaments.id')
        ->where('tournaments.user_id', '=', $userId)
        ->distinct()
        ->count('players.id');
        
        if ($nb != count($values)){
            // Not all user can be modified by current user
            return false;
        } else {
            // the complete array of players id can be modified by current user
            return true;
        }
    }
    
}