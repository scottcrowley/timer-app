<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use Illuminate\Http\Request;
use App\Filters\ProjectFilters;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Client  $client
     * @param  \App\Filters\ProjectFilters  $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client, ProjectFilters $filters)
    {
        $this->authorize('create', Project::class);

        $projects = Project::where('client_id', $client->id)->orderBy('name')->filter($filters)->get();

        return view('projects.index', compact('projects', 'client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        $this->authorize('create', Project::class);

        return view('projects.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $data['client_id'] = $request->route('client');

        $project = Project::create($data);

        session()->flash('flash', ['message' => 'The Project added successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($project, 201);
        }

        return redirect(route('projects.index', $project->client_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $response = $project->update(
            $request->validate([
                'name' => 'required',
                'description' => 'nullable',
                'active' => 'boolean'
            ])
        );

        session()->flash('flash', ['message' => 'The Project updated successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($response, 202);
        }

        return redirect(route('projects.index', $project->client->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('update', $project);

        $project->delete();

        session()->flash('flash', ['message' => 'The Project deleted successfully!', 'level' => 'success']);

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('projects.index', $project->client_id));
    }
}
