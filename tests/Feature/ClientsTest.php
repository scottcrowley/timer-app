<?php

namespace Tests\Feature;

use App\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_are_not_able_to_view_clients()
    {
        $this->get(route('clients.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_all_their_clients()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);

        $this->get(route('clients.index'))
            ->assertSee($client->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_clients_created_by_different_user()
    {
        $this->signIn($john = create('App\User', ['name' => 'John Doe']));

        $jane = create('App\User', ['name' => 'Jane Doe']);
        $client = createRaw('App\Client', ['user_id' => $jane->id]);

        $this->get(route('clients.index'))
            ->assertDontSee($client['name']);
    }

    /** @test */
    public function an_authenticated_user_can_add_a_new_client()
    {
        $this->signIn();

        $client = makeRaw('App\Client', ['user_id' => auth()->id()]);

        $this->post(route('clients.store'), $client)
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseHas('clients', $client);
    }

    /** @test */
    public function a_client_can_have_active_status_toggled()
    {
        $this->signIn();

        $client = create('App\Client');

        $this->assertTrue($client->isActive());

        $client->toggleActive();

        $this->assertFalse($client->fresh()->isActive());

        $client->toggleActive();

        $this->assertTrue($client->fresh()->isActive());
    }

    /** @test */
    public function a_guest_cannot_view_the_create_client_page()
    {
        $this->get(route('clients.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_the_create_client_page()
    {
        $this->signIn();

        $this->get(route('clients.create'))
            ->assertSee('New Client');
    }

    /** @test */
    public function a_guest_cannot_view_the_edit_client_page()
    {
        $this->get(route('clients.edit', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_the_edit_client_page()
    {
        $this->signIn();

        $client = create('App\Client');

        $this->get(route('clients.edit', $client->id))
            ->assertSee('Edit')
            ->assertSee($client->name);
    }

    /** @test */
    public function a_guest_cannot_view_the_client_show_page()
    {
        $this->get(route('clients.show', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_the_client_show_page()
    {
        $this->signIn();

        $client = create('App\Client');

        $this->get(route('clients.show', $client->id))
            ->assertSee($client->name);
    }

    /** @test */
    public function an_authenticated_user_can_update_a_client()
    {
        $this->signIn();

        $client = createRaw('App\Client');

        $client['name'] = 'Some new name';

        $this->post(route('clients.update', $client['id']), $client)
            ->assertRedirect(route('clients.show', $client['id']));

        $client = Client::find($client['id']);

        $this->assertDatabaseHas('clients', $client->toArray());
    }
}
