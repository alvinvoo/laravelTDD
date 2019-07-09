<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;
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

    public function invite(User $user){
        // attach here 'attached' the pivot data to the target user
        return $this->members()->attach($user);
    }

    public function members(){
        // a project can have many members
        // a member can have many projects
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
}
