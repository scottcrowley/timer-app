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
        $this->withoutExceptionHandling();

        $this->signIn($user = create('App\User'));

        create('App\Client', ['user_id' => $user->id], 5);

        $clients = $user->clients;

        $this->assertCount(5, $clients);
    }
}
