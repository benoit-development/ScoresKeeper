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
    
    /**
     * 
     * {@inheritDoc}
     * @see \Illuminate\Database\Eloquent\Model::toArray()
     */
    function toArray() {
        $result = parent::toArray();
        $result['date'] = strftime('%d/%m/%Y', $this->created_at->getTimeStamp());
        
        return $result;
    }
}
