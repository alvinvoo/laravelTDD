<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_activity_has_a_user(){
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User',$project->activity[0]->user);
    }
}
