<?php

namespace Tests\Setup;

class ProjectFactorySetup
{
  protected $tasksCount = 0;
  protected $user = null;

  public function withTasks($count){
    $this->tasksCount = $count;

    return $this; // return $this for fluent interface
  }

  public function ownedBy($user){
    $this->user = $user;

    return $this;
  }

  public function create(){
    $project = factory('App\Project')->create([
      'owner_id' => $this->user ?? factory('App\User')
    ]);

    // create task if count > 0
    factory('App\Task', $this->tasksCount)->create([
      'project_id' => $project->id
    ]);

    return $project;
  }
}