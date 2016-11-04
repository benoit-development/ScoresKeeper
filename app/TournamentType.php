<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentType extends Model
{
    /**
     * A list of valid types
     * 
     * @var array
     */
    const TYPE_LIST = [
        1 => 'card'
    ];
}
