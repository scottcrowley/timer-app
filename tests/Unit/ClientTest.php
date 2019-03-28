<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_a_name()
    {
        $this->signIn();

        $client = makeRaw('App\Client', ['name' => '']);

        $this->post(route('clients.store'), $client)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_requires_a_valid_user_id()
    {
        $this->signIn();

        $client = makeRaw('App\Client', ['user_id' => 8]);

        $this->post(route('clients.store'), $client)
            ->assertSessionHasErrors('user_id');
    }
}
