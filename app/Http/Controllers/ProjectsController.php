<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    //
    public function index() {
        $projects = auth()->user()->projects;

        return view('projects.index',compact('projects'));
    }

    public function show(Project $project) {

        // OR
        // if (auth()->user()->isNot($project->owner))
        // if ($project->owner->isNot(auth()->user())) {
        //     abort(403);
        // }
        $this->authorize('update', $project);

        return view('projects.show',compact('project'));
    }

    public function create() {
        return view('projects.create');
    }

    public function store() {
        // validate
        $attributes = request()->validate(
            [
                'title'=>'required',
                'description'=>'required',
                'notes' => 'min:3 | max:255'
            ]
        );

        // $attributes['owner_id'] = auth()->id();
        
       // presist
        // Project::create($attributes);

        $project = auth()->user()->projects()->create($attributes);

        // redirect
        return redirect($project->path());
    }

    public function update(Project $project) {

        //controller helper method
        $this->authorize('update', $project);

        $attributes = request()->validate(
            [
                'notes' => 'min:3 | max:255'
            ]
        );

        $project->update($attributes);

        // redirect
        return redirect($project->path());
    }
}
