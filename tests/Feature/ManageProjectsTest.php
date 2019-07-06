<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Facades\Tests\Setup\ProjectFactorySetup;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function guest_cannot_manage_project() {
        // $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get($project->path().'/edit')->assertRedirect('login');
        $this->post('/projects',$project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function an_auth_user_can_create_a_project(){

        // $this->withoutExceptionHandling();

        // $this->actingAs(factory('App\User')->create());//sign in user
        // helper method defined at TestCase
        $this->signIn();

        $attributes = [
            'title' => $this->faker->sentence,   // some convenient dummy data from faker trait
            'description' => $this->faker->sentence,
            'notes' => 'general notes'
        ];

        // just check that the create page route is available
        $this->get('/projects/create')->assertStatus(200); 

        // when the create page saves and post to /projects
        $response = $this->post('/projects', $attributes);
        
        $project = Project::where($attributes)->first();
        
        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project() {

        $this->withoutExceptionHandling();

        // $this->signIn();
        
        // $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $attributes = [
            'title'=>'a title changed',
            'description'=>'a description changed',
            'notes' => 'a notes changed'
        ];

        $project = ProjectFactorySetup::create();

        $this->actingAs($project->owner);
        
        $this->get($project->path(). '/edit', $attributes)->assertOK();

        $this->patch($project->path(), $attributes)
        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee('a title changed')
            ->assertSee('a description changed')
            ->assertSee('a notes changed');
    }

    /** @test */
    public function a_user_can_update_a_project_notes() {
        $attributes = [
            'notes' => 'a notes changed'
        ];

        $project = ProjectFactorySetup::create();

        $this->actingAs($project->owner);
        
        $this->patch($project->path(), $attributes)
        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_cannot_update_others_project() {

        // $this->withoutExceptionHandling();
        
        // $users = factory('App\User',2)->create();
        // $this->actingAs($users[0]);

        // $project = factory('App\Project')->create(['owner_id' => $users[1]]);

        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_their_own_project(){

        // $this->withoutExceptionHandling();

        // $this->signIn();
        
        // $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project = ProjectFactorySetup::create();

        $this->actingAs($project->owner);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_others_project(){

        // $this->withoutExceptionHandling();

        $users = factory('App\User',2)->create();
        $this->actingAs($users[0]);

        $project = factory('App\Project')->create(['owner_id' => $users[1]]);

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title() {
        $this->signIn();//sign in user

        // making it more specific
        $attributes = factory('App\Project')->raw(['title'=>'']);

        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description() {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description'=>'']);

        $this->post('/projects',$attributes)->assertSessionHasErrors('description');
    }

}
