<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;

class ProjectInvitationsController extends Controller
{
    //
    public function store(Project $project){

        $this->authorize('update', $project);

        $email = request()->validate([
            'email' => 'required | exists:users,email'
        ],[
            'email.exists' => 'The user you are inviting must have a birdboard account.'
        ]);

        $user = User::whereEmail($email)->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
