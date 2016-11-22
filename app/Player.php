<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model {
    
    /**
     * Change player order depending of the order in the array
     *
     * @param array $order            
     */
    public static function changeOrder($order) {
        $i = 1;
        DB::beginTransaction ();
        foreach ( $order as $id ) {
            
            $result = Player::where( 'players.id', '=', $id )->update ( [ 
                'order' => $i 
            ] );
            
            if (! $result) {
                DB::rollback ();
                return false;
            }
            
            $i ++;
        }
        DB::commit ();
        return true;
    }
}