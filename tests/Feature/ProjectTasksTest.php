<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_a_project() {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks(){
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task 1'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task 1']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks(){
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('test task');

        $this->patch($task->path(), ['body' => 'Test task changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task changed']);
    }

    /** @test */
    public function a_project_can_have_tasks(){

        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task 1']);

        $this->get($project->path())
            ->assertSee('Test task 1');
        
    }

    /** @test */
    public function a_task_can_be_updated(){

        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'task changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'task changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_requires_a_body(){

        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

}
