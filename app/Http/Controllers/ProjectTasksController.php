<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    //
    public function store(Project $project){

        $this->authorize('update', $project);

        // validate
        $attributes = request()->validate(['body'=>'required']);

        $project->addTask($attributes['body']);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task) {

        // if ($task->project->owner->isNot(auth()->user())) {
        //     abort(403);
        // }

        $this->authorize('update', $task->project);

        request()->validate(['body'=>'required']);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
