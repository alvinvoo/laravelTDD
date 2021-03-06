<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function task_belongs_to_a_project(){
        $task = factory('App\Task')->create();

        $this->assertInstanceOf('App\Project', $task->project);
    }

    /** @test */
    public function task_can_return_own_path(){

        // $this->withoutExceptionHandling();

        // $project = factory('App\Project')->create();
        // $task = $project->addTask(factory('App\Task')->raw()['body']);
        $task = factory('App\Task')->create();
        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /** @test */
    public function task_can_be_completed(){
        $this->withoutExceptionHandling();

        $task = factory('App\Task')->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed); // get a fresh model copy from db
    }

    /** @test */
    public function task_can_be_marked_as_incomplete(){
        $this->withoutExceptionHandling();

        $task = factory('App\Task')->create();

        $task->complete();
        
        $this->assertTrue($task->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed); // get a fresh model copy from db
    }
}
