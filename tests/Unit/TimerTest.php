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
        $timer = $this->createTimer();

        $this->assertInstanceOf(\App\Project::class, $timer->project);
    }

    /** @test */
    public function it_can_access_details_about_its_projects_client()
    {
        $timer = $this->createTimer();

        $this->assertInstanceOf(\App\Client::class, $timer->getClient());
    }

    /** @test */
    public function it_can_access_details_about_its_user()
    {
        $timer = $this->createTimer();

        $this->assertInstanceOf(\App\User::class, $timer->getUser());
    }

    /** @test */
    public function it_requires_a_description()
    {
        $timer = $this->createTimer('makeRaw', ['description' => '']);

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_requires_a_valid_start_date()
    {
        $timer = $this->createTimer('makeRaw', ['start' => '']);

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('start');
    }

    /** @test */
    public function it_requires_a_valid_end_date()
    {
        $timer = $this->createTimer('makeRaw', ['end' => '']);

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('end');
    }

    /** @test */
    public function it_requires_the_end_date_to_be_later_than_the_start_date()
    {
        $timer = $this->createTimer('makeRaw', ['start' => now(), 'end' => now()->subHours(1)]);

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('end');
    }

    /** @test */
    public function it_requires_a_billable_boolean()
    {
        $timer = $this->createTimer('makeRaw', ['billable' => '']);

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('billable');

        $timer['billable'] = 6;

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('billable');
    }

    /** @test */
    public function it_requires_a_billed_boolean()
    {
        $timer = $this->createTimer('makeRaw', ['billed' => '']);

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('billed');

        $timer['billed'] = 6;

        $this->post(route('timers.store', $timer['project_id']), $timer)
            ->assertSessionHasErrors('billed');
    }
}
