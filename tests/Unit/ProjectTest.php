<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_project_can_return_own_path()
    {   
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function a_project_belongs_to_an_owner() {
        //  $user = factory('App\User')->create();
        //  $project = factory('App\Project')->create(['owner_id' => $user->id]);

        // $this->assertEquals($project->owner_id, $project->owner->id);
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function a_project_can_add_a_task() {
        $project = factory('App\Project')->create();

        $task = $project->addTask('test task 1');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function a_project_can_invite_a_user(){
        $project = factory('App\Project')->create();
 
        $project->invite($user = factory('App\User')->create());

        $this->assertTrue($project->members->contains($user));
    }

}
