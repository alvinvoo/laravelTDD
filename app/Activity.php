<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    static protected $unguarded = true;

    public function subject(){
        return $this->morphTo();
    }
}
