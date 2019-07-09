<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactorySetup;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class InvitationsTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function non_owners_may_not_invite_users(){
      
      $project = ProjectFactorySetup::create();
      
      $user = $this->signIn();
      
      $this->actingAs($user)
      ->post($project->path() . '/invitations',[
         'email' => $user->email
         ])
         ->assertStatus((403));
         
      // even after this project invited the user, the user still cannot invite other
      $project->invite($user);

      $this->actingAs($user)
         ->post($project->path() . '/invitations')
         ->assertStatus((403));
   }

   /** @test */
   public function a_project_can_invite_a_user(){
        $this->withoutExceptionHandling();

      $project = ProjectFactorySetup::create();

      $userToInvite = factory('App\User')->create();

      $this->actingAs($project->owner)
         ->post($project->path().'/invitations', [
            'email' => $userToInvite->email
         ])
         ->assertRedirect($project->path());

      $this->assertTrue($project->members->contains($userToInvite));
   }

   /** @test */
   public function the_email_address_must_be_associated_with_a_valid_account(){

      // $this->withoutExceptionHandling();

      $project = ProjectFactorySetup::create();
   
      $this->actingAs($project->owner)
         ->post($project->path().'/invitations', [
            'email' => 'someuser@g.com'
         ])->assertSessionHasErrors(['email'=>'The user you are inviting must have a birdboard account.'],null,'invitations');
   }

   /** @test */
   public function an_invited_user_can_update_project(){
       $project = ProjectFactorySetup::create();

       $project->invite($newUser = factory('App\User')->create());

       $this->signIn($newUser);
       $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);

       $this->assertDatabaseHas('tasks', $task);
   }
}
