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
            ->assertSee(e($client->name));
    }

    /** @test */
    public function an_authenticated_user_may_not_view_clients_created_by_different_user()
    {
        $this->signIn($john = create('App\User', ['name' => 'John Doe']));

        $jane = create('App\User', ['name' => 'Jane Doe']);
        $client = createRaw('App\Client', ['user_id' => $jane->id]);

        $this->get(route('clients.index'))
            ->assertDontSee(e($client['name']));
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
    public function an_authenticated_user_may_only_view_the_edit_client_page_if_its_theirs()
    {
        $this->signIn();

        $client = create('App\Client');

        $this->get(route('clients.edit', $client->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_the_edit_client_page()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);

        $this->get(route('clients.edit', $client->id))
            ->assertSee(e($client->name));
    }

    /** @test */
    public function a_guest_cannot_view_the_client_show_page()
    {
        $this->get(route('clients.show', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_may_only_view_the_client_show_page_if_its_theirs()
    {
        $this->signIn();

        $client = create('App\Client');

        $this->get(route('clients.show', $client->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_their_client_show_page()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);

        $this->get(route('clients.show', $client->id))
            ->assertSee(e($client->name));
    }

    /** @test */
    public function an_authenticated_user_may_only_update_a_client_if_its_theirs()
    {
        $this->signIn();

        $client = createRaw('App\Client');

        $this->post(route('clients.update', $client['id']), $client)
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_update_their_client()
    {
        $this->signIn();

        $client = createRaw('App\Client', ['user_id' => auth()->id()]);

        $client['name'] = 'Some new name';

        $this->post(route('clients.update', $client['id']), $client)
            ->assertRedirect(route('clients.index'));

        $client = Client::find($client['id']);

        $this->assertDatabaseHas('clients', $client->toArray());
    }

    /** @test */
    public function an_authenticated_user_may_only_delete_a_client_if_its_theirs()
    {
        $this->signIn();

        $client = createRaw('App\Client');

        $this->delete(route('clients.delete', $client['id']))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_delete_their_client()
    {
        $this->signIn();

        $client = createRaw('App\Client', ['user_id' => auth()->id()]);

        $this->delete(route('clients.delete', $client['id']))
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseMissing('clients', $client);
    }

    /** @test */
    public function all_related_projects_and_timers_are_removed_when_a_client_is_deleted()
    {
        $timer = $this->createTimer();

        $this->delete(route('clients.delete', $timer->getClient()->id));

        $this->assertDatabaseMissing('projects', ['id' => $timer->project->id]);
        $this->assertDatabaseMissing('timers', ['id' => $timer->id]);
    }
}
