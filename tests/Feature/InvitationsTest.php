<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactorySetup;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function a_project_can_invite_a_user(){
        // $this->withoutExceptionHandling();

       $project = ProjectFactorySetup::create();

       $project->invite($newUser = factory('App\User')->create());

       $this->signIn($newUser);
       $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);

       $this->assertDatabaseHas('tasks', $task);
   }
}
