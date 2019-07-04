<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    // protected $guarded = [];
    // same as above
    static protected $unguarded = true;

    protected $touches = ['project'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path() {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }
}
