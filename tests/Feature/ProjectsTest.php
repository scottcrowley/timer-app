<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_are_not_able_to_view_projects()
    {
        $this->get(route('projects.index', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_only_view_all_their_projects_if_its_their_client()
    {
        $this->signIn();

        $jane = create('App\User');

        $janesProject = $this->createProject('create', [], null, $jane);

        $this->get(route('projects.index', $janesProject->client_id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_all_their_projects()
    {
        $project = $this->createProject();

        $this->get(route('projects.index', $project->client_id))
            ->assertSee($project->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_projects_created_by_different_users()
    {
        $this->signIn();

        $janesProject = create('App\Project');

        $this->get(route('projects.index', $janesProject->client_id))
            ->assertDontSee($janesProject->name);
    }

    /** @test */
    public function an_authenticated_user_can_add_a_new_project()
    {
        $project = $this->createProject('makeRaw');

        $this->post(route('projects.store', $project['client_id']), $project)
            ->assertRedirect(route('projects.index', $project['client_id']));

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function an_authenticated_user_may_only_add_projects_to_their_own_clients()
    {
        $this->signIn();

        $jane = create('App\User');

        $janesProject = $this->createProject('create', [], null, $jane);

        $johnsProject = makeRaw('App\Project', ['client_id' => $janesProject->client_id]);

        $this->post(route('projects.store', $janesProject->client_id), $johnsProject)
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_can_have_active_status_toggled()
    {
        $project = $this->createProject();

        $this->assertTrue($project->isActive());

        $project->toggleActive();

        $this->assertFalse($project->fresh()->isActive());

        $project->toggleActive();

        $this->assertTrue($project->fresh()->isActive());
    }

    /** @test */
    public function a_guest_cannot_view_the_create_project_page()
    {
        $this->get(route('projects.create', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_only_view_the_create_project_page_if_its_their_client()
    {
        $this->signIn();

        $janesClient = create('App\Client');

        $this->get(route('projects.create', $janesClient->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_the_create_project_page_for_their_client()
    {
        $this->signIn();

        $client = create('App\Client', ['user_id' => auth()->id()]);

        $this->get(route('projects.create', $client->id))
            ->assertSee('New Project');
    }

    /** @test */
    public function a_guest_cannot_view_the_edit_project_page()
    {
        $this->get(route('projects.edit', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_only_view_the_edit_project_page_if_its_their_client()
    {
        $this->signIn();

        $jane = create('App\User');

        $janesProject = $this->createProject('create', [], null, $jane);

        $this->get(route('projects.edit', $janesProject->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_the_edit_project_page()
    {
        $project = $this->createProject();

        $this->get(route('projects.edit', $project->id))
            ->assertSee('Edit')
            ->assertSee($project->name);
    }

    /** @test */
    public function a_guest_cannot_view_the_project_show_page()
    {
        $this->get(route('projects.show', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_only_view_the_project_show_page_if_its_their_client()
    {
        $this->signIn();

        $jane = create('App\User');

        $janesProject = $this->createProject('create', [], null, $jane);

        $this->get(route('projects.show', $janesProject->id))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_view_the_project_show_page()
    {
        $project = $this->createProject();

        $this->get(route('projects.show', $project->id))
            ->assertSee($project->name);
    }

    /** @test */
    public function an_authenticated_user_can_only_update_a_project_if_its_their_client()
    {
        $this->signIn();

        $jane = create('App\User');

        $janesProject = $this->createProject('createRaw', [], null, $jane);

        $janesProject['name'] = 'Some new name';

        $this->post(route('projects.update', $janesProject['id']), $janesProject)
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_update_a_project()
    {
        $project = $this->createProject('createRaw');

        $project['name'] = 'Some new name';

        $this->post(route('projects.update', $project['id']), $project)
            ->assertRedirect(route('projects.show', $project['id']));

        $project = Project::without('client')->find($project['id']);

        $this->assertDatabaseHas('projects', $project->toArray());
    }
}
