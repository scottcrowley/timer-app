<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_details_about_its_client()
    {
        $project = $this->createProject();

        $this->assertInstanceOf(\App\Client::class, $project->client);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $project = $this->createProject('makeRaw', ['name' => '']);

        $this->post(route('projects.store', $project['client_id']), $project)
            ->assertSessionHasErrors('name');

        $project = $this->createProject('createRaw', ['name' => '']);

        $this->post(route('projects.update', $project['id']), $project)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_requires_a_valid_client_id()
    {
        $this->signIn();

        $project = makeRaw('App\Project', ['client_id' => 8]);

        $this->post(route('projects.store', $project['client_id']), $project)
            ->assertStatus(404);
    }

    /** @test */
    public function it_can_access_all_its_timers()
    {
        $project = $this->createProject('create');

        $timers = $this->createTimer('create', [], 5, null, null, $project);

        $this->assertCount(5, $project->timers);
    }

    /** @test */
    public function it_can_calculate_total_time_for_all_timers()
    {
        $project = $this->createProject('create');

        $timers = $this->createTimer('create', ['start' => now()->subMinutes(136), 'end' => now()], 2, null, null, $project);

        $totalTime = round(($timers[0]->getTotalRawTime() + $timers[1]->getTotalRawTime()), 1);

        $this->assertequals($totalTime, $project->all_time);
    }

    /** @test */
    public function it_can_calculate_total_time_for_all_billable_timers()
    {
        $project = $this->createProject('create');

        $billableTimers = $this->createTimer('create', ['start' => now()->subMinutes(136), 'end' => now()], 2, null, null, $project);

        $nonBillableTimers = $this->createTimer('create', ['start' => now()->subMinutes(136), 'end' => now(), 'billable' => false], 2, null, null, $project);

        $totalBillable = round(($billableTimers[0]->getTotalRawTime() + $billableTimers[1]->getTotalRawTime()), 1);

        $this->assertEquals($totalBillable, $project->all_billable_time);
    }

    /** @test */
    public function it_can_calculate_total_time_for_all_nonbillable_timers()
    {
        $project = $this->createProject('create');

        $billableTimers = $this->createTimer('create', ['start' => now()->subMinutes(136), 'end' => now()], 2, null, null, $project);

        $nonBillableTimers = $this->createTimer('create', ['start' => now()->subMinutes(136), 'end' => now(), 'billable' => false], 2, null, null, $project);

        $totalNonBillable = round(($nonBillableTimers[0]->getTotalRawTime() + $nonBillableTimers[1]->getTotalRawTime()), 1);

        $this->assertEquals($totalNonBillable, $project->all_non_billable_time);
    }

    /** @test */
    public function it_can_access_all_timers_that_have_been_billed()
    {
        $project = $this->createProject('create');

        $billedTimers = $this->createTimer('create', ['billed' => true], 2, null, null, $project);

        $nonBilledTimers = $this->createTimer('create', [], 3, null, null, $project);

        $this->assertCount(2, $project->billed_timers);
    }

    /** @test */
    public function it_can_access_all_timers_that_have_not_been_billed()
    {
        $project = $this->createProject('create');

        $this->createTimer('create', ['billed' => true], 2, null, null, $project);

        $this->createTimer('create', [], 3, null, null, $project);

        $this->assertCount(3, $project->non_billed_timers);
    }

    /** @test */
    public function it_can_remember_any_applied_filters_for_a_specific_client()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);
        $otherClient = create('App\Client', ['user_id' => auth()->id()]);

        $activeProject = $this->createProject('create', [], null, null, $client);
        $inactiveProject = $this->createProject('create', ['active' => false], null, null, $client);

        $otherActiveProject = $this->createProject('create', [], null, null, $otherClient);
        $otherInactiveProject = $this->createProject('create', ['active' => false], null, null, $otherClient);

        $this->get(route('projects.index', $client->id))
            ->assertSee(e($activeProject->name))
            ->assertSee(e($inactiveProject->name));

        $this->json('post', route('sessions.projects.store', $client->id), [
            'active' => 1
        ])
            ->assertStatus(201)
            ->assertSessionHas('filters.projects.' . $client->id, ['active' => 1]);

        $this->get(route('projects.index', $client->id))
            ->assertSee(e($activeProject->name))
            ->assertDontSee(e($inactiveProject->name));

        $this->get(route('projects.index', $otherClient->id))
            ->assertSee(e($otherActiveProject->name))
            ->assertSee(e($otherInactiveProject->name));

        $this->json('post', route('sessions.projects.store', $client->id), ['inactive' => 1])
            ->assertStatus(201)
            ->assertSessionHas('filters.projects.' . $client->id, ['inactive' => 1]);

        $this->get(route('projects.index', $client->id))
            ->assertDontSee(e($activeProject->name))
            ->assertSee(e($inactiveProject->name));
    }

    /** @test */
    public function it_can_clear_the_filters_from_the_session()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);

        $activeProject = $this->createProject('create', [], null, null, $client);
        $inactiveProject = $this->createProject('create', ['active' => false], null, null, $client);

        $this->json('post', route('sessions.projects.store', $client->id), ['active' => 1]);

        $this->get(route('projects.index', $client->id))
            ->assertSee(e($activeProject->name))
            ->assertDontSee(e($inactiveProject->name));

        $this->json('delete', route('sessions.projects.delete', $client->id))
            ->assertStatus(204)
            ->assertSessionMissing('filters.projects.' . $client->id);

        $this->get(route('projects.index', $client->id))
            ->assertSee(e($activeProject->name))
            ->assertSee(e($inactiveProject->name));
    }
}
