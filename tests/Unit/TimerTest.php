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
}
