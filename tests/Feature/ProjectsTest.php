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
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = create('App\Project', ['user_id' => auth()->id()]);

        $this->get(route('projects.index'))
            ->assertSee($project->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_projects_created_by_different_user()
    {
        $this->signIn($john = create('App\User', ['name' => 'John Doe']));

        $jane = create('App\User', ['name' => 'Jane Doe']);
        $project = createRaw('App\Project', ['user_id' => $jane->id]);

        $this->get(route('projects.index'))
            ->assertDontSee($project['name']);
    }

    /** @test */
    public function an_authenticated_user_can_add_a_new_project()
    {
        $this->signIn();

        $project = makeRaw('App\Project', ['user_id' => auth()->id()]);

        $this->post(route('projects.store'), $project)
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $project);
    }

    /** @test */
    public function a_project_can_have_active_status_toggled()
    {
        $this->signIn();

        $project = create('App\Project');

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
        $this->signIn();

        $project = create('App\Project');

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
        $this->signIn();

        $project = createRaw('App\Project');

        $project['name'] = 'Some new name';

        $this->post(route('projects.update', $project['id']), $project)
            ->assertRedirect(route('projects.show', $project['id']));

        $project = Project::find($project['id']);

        $this->assertDatabaseHas('projects', $project->toArray());
    }
}
