<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

use Facades\Tests\Setup\ProjectFactorySetup;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_has_projects(){
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessible_projects(){
        $john = $this->signIn();

        ProjectFactorySetup::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $sally = factory('App\User')->create();
        $dillon = factory('App\User')->create();

        // project by another user
        $sallyProject = tap(ProjectFactorySetup::ownedBy($sally)->create())->invite($dillon);

        $this->assertCount(1, $dillon->accessibleProjects());
        $this->assertCount(1, $john->accessibleProjects());

        $sallyProject->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
