<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;

class ProjectsController extends Controller
{
    //
    public function index() {
        // get all projects user is owner and member of
        $projects = auth()->user()->accessibleProjects();

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
        $attributes = $this->validateRequest();

        // $attributes['owner_id'] = auth()->id();
        
       // presist
        // Project::create($attributes);

        $project = auth()->user()->projects()->create($attributes);

        // redirect
        return redirect($project->path());
    }

    public function edit(Project $project) {
        return view('projects.edit', compact('project'));
    }

    // public function update(Project $project) {

    //     //controller helper method
    //     $this->authorize('update', $project);

    //     // validate
    //     $attributes = $this->validateRequest();
                
    //     $project->update($attributes);

    //     // redirect
    //     return redirect($project->path());
    // }

    public function update(UpdateProjectRequest $request) {
        // iter 1. basic form request
        // $project->update($request->validated());

        // iter 2. let the form request class handle the persistance
        // $request->update();

        // return redirect($project->path());
        // iter 3. remove Project injection and chain everything with request object
        return redirect($request->update()->path());
    }

    public function destroy(Project $project) {
        $this->authorize('update', $project);
        
        $project->delete();

        return redirect('/projects');
    }

    private function validateRequest(){
        return request()->validate(
            [
                'title'=>'sometimes | required',
                'description'=>'sometimes | required',
                'notes' => 'nullable'
            ]
        );
    }
}
