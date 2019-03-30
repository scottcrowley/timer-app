<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_details_about_its_project()
    {
        $project = $this->createProject();

        $timer = create('App\Timer', ['project_id' => $project->id]);

        $this->assertEquals($project->name, $timer->project->name);
    }

    /** @test */
    public function it_requires_a_description()
    {
        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id, 'description' => '']);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_requires_a_valid_start_date()
    {
        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id, 'start' => '']);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('start');
    }

    /** @test */
    public function it_requires_a_valid_end_date()
    {
        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id, 'end' => '']);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('end');
    }

    /** @test */
    public function it_requires_the_end_date_to_be_later_than_the_start_date()
    {
        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id, 'start' => now(), 'end' => now()->subHours(1)]);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('end');
    }

    /** @test */
    public function it_requires_a_billable_boolean()
    {
        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id, 'billable' => '']);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('billable');

        $timer['billable'] = 6;

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('billable');
    }

    /** @test */
    public function it_requires_a_billed_boolean()
    {
        $project = $this->createProject();

        $timer = makeRaw('App\Timer', ['project_id' => $project->id, 'billed' => '']);

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('billed');

        $timer['billed'] = 6;

        $this->post(route('timers.store', $project->id), $timer)
            ->assertSessionHasErrors('billed');
    }
}
