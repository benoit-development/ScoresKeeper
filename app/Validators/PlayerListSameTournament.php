<?php

namespace App\Validators;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Player;
use Illuminate\Support\Facades\DB;

/**
 * Validator checking all players belongs to the same tournament
 * 
 * @author Benoit BOUSQUET
 *
 */
class PlayerListSameTournament {
    
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
        
        // get players data
        $nb = Player::whereIn('players.id', $values)
        ->distinct()
        ->count(DB::raw('players.tournament_id'));
        
        if ($nb != 1){
            // Players doesn't belong to the same tournament
            return false;
        } else {
            // All players belong to the same tournament
            return true;
        }
    }
    
}