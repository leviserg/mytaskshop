<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function typeName(){
        return $this->hasOne('App\Type','id','type');
    }

    public function c1Name($type){
        return $this->hasOne('App\C1','cid','param');
    }

    public function c2Name($type){
        return $this->hasOne('App\C2','cid','param');
    }

    public function c3Name($type){
        return $this->hasOne('App\C3','cid','param');
    }
}
