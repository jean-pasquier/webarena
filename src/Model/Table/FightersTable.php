<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FightersTable extends Table
{
    
    
    public function getBestFighter(){
        $res = $this->find()
                ->select(['name', 'xp', 'level'])
                ->order(['level' => 'DESC'])
                ->first();
                //->groupBy('level');
        //pr($res);
        $best = array();
        array_push($best, $res['name']);
        array_push($best, $res['xp']);
        array_push($best, $res['level']);
        return $best;
    }
}
