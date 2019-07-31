<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class C3 extends Model
{
    public function typeName(){
        return $this->hasOne('App\Type','id','type');
    }
}
