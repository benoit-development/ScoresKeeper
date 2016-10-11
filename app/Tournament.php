<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['user_id'];
    
}
