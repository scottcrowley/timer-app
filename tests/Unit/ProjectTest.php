<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_a_name()
    {
        $this->signIn();

        $project = makeRaw('App\Project', ['name' => '']);

        $this->post(route('projects.store'), $project)
            ->assertSessionHasErrors('name');

        $project = createRaw('App\Project', ['name' => '']);

        $this->post(route('projects.update', $project['id']), $project)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_requires_a_valid_user_id()
    {
        $this->signIn();

        $project = makeRaw('App\Project', ['user_id' => 8]);

        $this->post(route('projects.store'), $project)
            ->assertSessionHasErrors('user_id');
    }

    /** @test */
    public function it_requires_a_valid_client_id()
    {
        $this->signIn();

        $project = makeRaw('App\Project', ['client_id' => 8]);

        $this->post(route('projects.store'), $project)
            ->assertSessionHasErrors('client_id');

        $project = createRaw('App\Project', ['client_id' => 8]);

        $this->post(route('projects.update', $project['id']), $project)
                ->assertSessionHasErrors('client_id');
    }

    /** @test */
    public function it_can_access_details_about_its_client()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);

        $project = create('App\Project', ['user_id' => auth()->id(), 'client_id' => $client->id]);

        $projectClient = $project->client;

        $this->assertEquals($projectClient->name, $client->name);
    }
}
