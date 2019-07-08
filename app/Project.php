<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $guarded = [];

    public function path(){
        return '/projects/' . $this->id;
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function addTask($body){
        return $this->tasks()->create(compact('body'));
    }
    
    public function activity(){
        return $this->hasMany(Activity::class)->latest();
    }

    public function recordActivity($description){

        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);
    }

    private function activityChanges($description) {
        if ($description === 'updated') {
            return [
                // need to get the whole array attributes to minus off
                'before'  => array_except(array_diff($this->original, $this->toArray()),'updated_at'), 
                'after' => array_except($this->changes, 'updated_at')
            ];
        };
    }

}
