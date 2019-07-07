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

    protected $casts = [
        'completed' => 'boolean' // autocast TINYINT field from DB to boolean in app
    ];

    // protected static function boot(){
    //     parent::boot();

    //     static::created(function ($task){ // manually registering created hook
    //         $task->project->recordActivity('created_task');
    //     });

    //     // static::updated(function ($task){ // manually registering created hook
    //     //     if (!$task->completed) {
    //     //         $task->project->recordActivity('uncompleted_task');    
    //     //         return;
    //     //     };

    //     //     $task->project->recordActivity('completed_task');
    //     // });
    // }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path() {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }

    public function complete(){
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete(){
        $this->update(['completed' => false]);

        $this->recordActivity('incompleted_task');
    }

    public function activity(){
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity($description){
        $this->activity()->create([
            'project_id' => $this->project->id,
            'description'=> $description
        ]);
    }
}
