<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_all_its_clients()
    {
        $this->signIn($user = create('App\User'));

        create('App\Client', ['user_id' => $user->id], 5);

        $clients = $user->clients;

        $this->assertCount(5, $clients);
    }

    /** @test */
    public function it_can_access_all_its_projects_for_all_clients()
    {
        $this->createProject('create', [], 5);

        $projects = auth()->user()->projects;

        $this->assertCount(5, $projects);
    }
}
