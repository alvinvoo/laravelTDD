<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    //
    public function store(Project $project){

        if ($project->owner->isNot(auth()->user())) {
            abort(403);
        }

        // validate
        $attributes = request()->validate(['body'=>'required']);

        $project->addTask($attributes['body']);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task) {

        if ($project->owner->isNot(auth()->user())) {
            abort(403);
        }

        request()->validate(['body'=>'required']);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
