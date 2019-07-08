<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    static protected $unguarded = true;

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
