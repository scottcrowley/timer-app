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
        $this->get(route('projects.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_all_their_projects()
    {
        $project = $this->createProject();

        $this->get(route('projects.index'))
            ->assertSee($project->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_projects_created_by_different_users()
    {
        $this->signIn();

        $janesProject = create('App\Project');

        $this->get(route('projects.index'))
            ->assertDontSee($janesProject->name);
    }

    /** @test */
    public function an_authenticated_user_can_add_a_new_project()
    {
        $project = $this->createProject('makeRaw');

        $this->post(route('projects.store'), $project)
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function an_authenticated_user_may_only_add_projects_to_their_own_clients()
    {
        $this->signIn();

        $jane = create('App\User');

        $janesProject = $this->createProject('create', [], null, $jane);

        $johnsProject = makeRaw('App\Project', ['client_id' => $janesProject->client_id]);

        dd();
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
        $this->get(route('projects.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_the_create_project_page()
    {
        $this->signIn();

        $this->get(route('projects.create'))
            ->assertSee('New Project');
    }

    /** @test */
    public function a_guest_cannot_view_the_edit_project_page()
    {
        $this->get(route('projects.edit', 1))
            ->assertRedirect(route('login'));
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
    public function an_authenticated_user_can_view_the_project_show_page()
    {
        $this->signIn();

        $project = create('App\Project');

        $this->get(route('projects.show', $project->id))
            ->assertSee($project->name);
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
