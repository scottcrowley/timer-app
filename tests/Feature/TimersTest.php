<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_may_not_view_any_timers()
    {
        $this->get(route('timers.index', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_may_only_view_all_their_timers_for_a_given_project_if_its_their_client()
    {
        $this->signIn();

        $project = $this->createProject('create', [], null, create('App\User'));

        $this->get(route('timers.index', $project->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_view_all_their_timers_for_a_given_project()
    {
        $timer = $this->createTimer();

        $this->get(route('timers.index', $timer->project_id))
            ->assertSee(e($timer->description));
    }

    /** @test */
    public function a_guest_may_not_view_the_timer_create_page()
    {
        $this->get(route('timers.create', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_may_only_view_the_timer_create_page_if_its_their_client()
    {
        $this->signIn();

        $project = $this->createProject('create', [], null, create('App\User'));

        $this->get(route('timers.create', $project->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_view_the_timer_create_page_for_their_client()
    {
        $project = $this->createProject();

        $this->get(route('timers.create', $project->id))
            ->assertSee(e($project->name));
    }

    /** @test */
    public function an_authenticated_user_may_only_add_a_new_timer_if_its_their_client()
    {
        $this->signIn();

        $timer = $this->createTimer('makeRaw', [], null, create('App\User'));

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_add_a_new_timer_to_a_project()
    {
        $timer = $this->createTimer('makeRaw');

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertRedirect(route('timers.index', $timer['project_id']));

        $this->assertDatabaseHas('timers', $timer);
    }

    /** @test */
    public function an_authenticated_user_may_only_view_the_timer_update_page_if_its_their_client()
    {
        $this->signIn();

        $timer = $this->createTimer('create', [], null, create('App\User'));

        $this->get(route('timers.edit', $timer->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_view_the_timer_edit_page_for_their_client()
    {
        $timer = $this->createTimer();

        $this->get(route('timers.edit', $timer->id))
            ->assertSee(e($timer->description));
    }

    /** @test */
    public function an_authenticated_user_can_only_view_the_timer_show_page_if_its_their_client()
    {
        $this->signIn();

        $timer = $this->createTimer('create', [], null, create('App\User'));

        $this->get(route('timers.show', $timer->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_the_timer_show_page()
    {
        $timer = $this->createTimer();

        $this->get(route('timers.show', $timer->id))
            ->assertSee(e($timer->description));
    }

    /** @test */
    public function an_authenticated_user_may_only_update_a_timer_if_its_their_client()
    {
        $this->signIn();

        $timer = $this->createTimer('create', [], null, create('App\User'));

        $this->post(route('timers.update', $timer->id), $timer->toArray())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_update_a_timer_for_their_client()
    {
        $timer = $this->createTimer();

        $timer->description = 'Some new description';

        $this->post(route('timers.update', $timer->id), $timer->toArray())
            ->assertRedirect(route('timers.index', $timer->project_id));

        $this->assertDatabaseHas('timers', ['description' => 'Some new description']);
    }

    /** @test */
    public function an_authenticated_user_may_only_delete_a_timer_if_its_their_client()
    {
        $this->signIn();

        $timer = $this->createTimer('create', [], null, create('App\User'));

        $this->delete(route('timers.delete', $timer->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_delete_a_timer_for_their_client()
    {
        $timer = $this->createTimer();

        $this->delete(route('timers.delete', $timer->id))
            ->assertRedirect(route('timers.index', $timer->project_id));

        $this->assertDatabaseMissing('timers', ['id' => $timer->id]);
    }
}
