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

    /** @test */
    public function it_can_remember_any_applied_filters()
    {
        $this->signIn();

        $activeClient = create('App\Client', ['user_id' => auth()->id()]);
        $inactiveClient = create('App\Client', [
            'user_id' => auth()->id(),
            'active' => false
        ]);

        $this->get(route('clients.index'))
            ->assertSee($activeClient->name)
            ->assertSee($inactiveClient->name);

        $this->json('post', route('sessions.clients.store'), ['active' => 1])
            ->assertStatus(201)
            ->assertSessionHas('filters.clients', ['active' => 1]);

        $this->get(route('clients.index'))
            ->assertSee($activeClient->name)
            ->assertDontSee($inactiveClient->name);

        $this->json('post', route('sessions.clients.store'), ['inactive' => 1])
            ->assertStatus(201)
            ->assertSessionHas('filters.clients', ['inactive' => 1]);

        $this->get(route('clients.index'))
            ->assertDontSee($activeClient->name)
            ->assertSee($inactiveClient->name);
    }

    /** @test */
    public function it_can_clear_the_filters_from_the_session()
    {
        $this->signIn();

        $activeClient = create('App\Client', ['user_id' => auth()->id()]);
        $inactiveClient = create('App\Client', [
            'user_id' => auth()->id(),
            'active' => false
        ]);

        $this->json('post', route('sessions.clients.store'), ['active' => 1]);

        $this->get(route('clients.index'))
            ->assertSee($activeClient->name)
            ->assertDontSee($inactiveClient->name);

        $this->json('delete', route('sessions.clients.delete'))
            ->assertStatus(204)
            ->assertSessionMissing('filters.clients');

        $this->get(route('clients.index'))
            ->assertSee($activeClient->name)
            ->assertSee($inactiveClient->name);
    }
}
