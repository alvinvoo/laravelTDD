<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function guest_cannot_create_project() {
        // $this->withoutExceptionHandling();

        $attributes = factory('App\Project')->raw();

        $this->post('/projects',$attributes)->assertRedirect('login');
    }

    /** @test */
    public function guest_cannot_view_projects() {
        // $this->withoutExceptionHandling();

        $this->get('/projects')->assertRedirect('login');
    }

    /** @test */
    public function guest_cannot_view_project() {
        // $this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function an_auth_user_can_create_a_project(){

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());//sign in user

        $attributes = [
            'title' => $this->faker->sentence,   // some convenient dummy data from faker trait
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_their_own_project(){

        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->actingAs($user);
        
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

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
        $this->actingAs(factory('App\User')->create());//sign in user

        // making it more specific
        $attributes = factory('App\Project')->raw(['title'=>'']);

        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description() {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description'=>'']);

        $this->post('/projects',$attributes)->assertSessionHasErrors('description');
    }

}
