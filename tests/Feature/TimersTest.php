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

        $jane = create('App\User');

        $project = $this->createProject('create', [], null, $jane);

        $this->get(route('timers.index', $project->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_view_all_their_timers_for_a_given_project()
    {
        $project = $this->createProject();

        $timer = create('App\Timer', ['project_id' => $project->id]);

        $this->get(route('timers.index', $project->id))
            ->assertSee($timer->description);
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

        $jane = create('App\User');

        $project = $this->createProject('create', [], null, $jane);

        $this->get(route('timers.create', $project->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_view_the_timer_create_page_for_their_client()
    {
        $project = $this->createProject();

        $this->get(route('timers.create', $project->id))
            ->assertSee($project->name);
    }

    /** @test */
    public function an_authenticated_user_may_only_add_a_new_timer_if_its_their_client()
    {
        $this->signIn();

        $jane = create('App\User');

        $project = $this->createProject('create', [], null, $jane);

        $timer = makeRaw('App\Timer', ['project_id' => $project->id]);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_add_a_new_timer_to_a_project()
    {
        $this->withoutExceptionHandling();

        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id]);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertRedirect(route('timers.index', $project->id));

        $this->assertDatabaseHas('timers', $timer);
    }
}
