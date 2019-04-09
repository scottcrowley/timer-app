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

        $client = makeRaw('App\Client', ['user_id' => auth()->id(), 'name' => '']);

        $this->post(route('clients.store'), $client)
            ->assertSessionHasErrors('name');

        $client = createRaw('App\Client', ['user_id' => auth()->id(), 'name' => '']);

        $this->post(route('clients.update', $client['id']), $client)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_can_access_all_of_its_projects()
    {
        $this->signIn();

        $client = create('App\Client');

        create('App\Project', ['client_id' => $client->id], 5);

        $this->assertEquals(5, $client->project_count);
    }
}
