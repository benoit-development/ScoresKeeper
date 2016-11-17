<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function toArray() {
        $result = parent::toArray();
        $result['date'] = strftime('%d/%m/%Y', $this->created_at->getTimeStamp());
        
        return $result;
    }
    
    /**
     * Get paginated list of tournaments
     * 
     * return Iterator
     */
    public static function getPaginatedList() {
        return self::orderBy('created_at', 'desc')->where(['user_id' => Auth::user()->id, 'archived' => false])->paginate(10);
    }


    /**
     * find a tournament in the database. This function check if :
     * - the tournament is not archived
     * - the user is the owner of this tournament
     * 
     * method return null if tournament is not found
     * 
     * @param int $id tournament id
     * 
     * return Tournament
     */
    public static function find($id) {
        
    }
    
    /**
     * Get all useful informations of this tournament like players, scrores, ...
     * 
     * @return array
     */
    public function getDetails() {
        return [
            'players' => Player::orderBy('order', 'asc')
                ->select('id', 'name', 'tournament_id', 'order')
                ->where('tournament_id', $this->id)->get(),
        ];
    }
    
    /**
     * get the max order the the players in this tournament
     * 
     * @return int
     */
    public function getPlayersMaxOrder() {
        return Player::where(['tournament_id' => $this->id])->max('order');
    }
}
