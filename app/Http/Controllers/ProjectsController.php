<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        $this->authorize('create', Project::class);

        $projects = auth()->user()->projects;

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

        $project = Project::create(
            $request->validate([
                'name' => 'required',
                'description' => 'nullable',
                'client_id' => 'exists:clients,id',
            ])
        );

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
                'client_id' => 'exists:clients,id',
                'active' => 'boolean'
            ])
        );

        session()->flash('flash', ['message' => 'The Project updated successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($response, 202);
        }

        return redirect(route('projects.show', $project->id));
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

        session()->flash('flash', 'The Project was deleted successfully!');

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('projects.index', $project->client_id));
    }
}
