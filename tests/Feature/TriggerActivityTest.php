<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactorySetup;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function creating_a_project()
    {
        // $this->withoutExceptionHandling();

        $project = ProjectFactorySetup::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description); 
    }

    /** @test */
    public function updating_a_project()
    {
        // $this->withoutExceptionHandling();

        $project = ProjectFactorySetup::create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description); 
    }

    /** @test */
    public function creating_a_new_task(){
        $project = ProjectFactorySetup::create();

        $project->addTask('some tasks');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf('App\Task', $activity->subject);
            $this->assertEquals('some tasks', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task(){
        $project = ProjectFactorySetup::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true 
            ]);

        $this->assertCount(3, $project->activity);     
        
        tap($project->activity->last(), function($activity){
            $this->assertEquals('completed_task', $activity->description); 
            $this->assertInstanceOf('App\Task', $activity->subject);
        });
    }
    
    /** @test */
    public function incompleting_a_task(){
        $project = ProjectFactorySetup::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true 
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false 
        ]);

        $project = $project->fresh();

        $this->assertCount(4, $project->activity);
        
        tap($project->activity->last(), function($activity){
            $this->assertEquals('incompleted_task', $activity->description); 
            $this->assertInstanceOf('App\Task', $activity->subject);
        });
    }

    /** @test */
    public function deleting_a_task(){
        $project = ProjectFactorySetup::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
