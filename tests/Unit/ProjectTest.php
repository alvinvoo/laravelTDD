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

}
