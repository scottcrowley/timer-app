<?php

namespace App\Http\Controllers;

use App\Timer;
use App\Project;
use Illuminate\Http\Request;

class TimersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('create', Timer::class);

        $timers = Timer::where('project_id', $project->id)->latest('end')->get();

        return view('timers.index', compact('timers', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $this->authorize('create', Timer::class);

        return view('timers.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Timer::class);

        $data = $request->validate([
            'description' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'billable' => 'required|boolean',
            'billed' => 'required|boolean'
        ]);

        $data['project_id'] = $request->route('project');

        $timer = Timer::create($data);

        session()->flash('flash', ['message' => 'The Timer added successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($timer, 201);
        }

        return redirect(route('timers.index', $timer->project_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function show(Timer $timer)
    {
        $this->authorize('update', $timer);

        return view('timers.show', compact('timer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function edit(Timer $timer)
    {
        $this->authorize('update', $timer);

        return view('timers.edit', compact('timer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timer $timer)
    {
        $this->authorize('update', $timer);

        $timer->update(
            $request->validate([
                'description' => 'required',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'billable' => 'required|boolean',
                'billed' => 'required|boolean'
            ])
        );

        session()->flash('flash', ['message' => 'The Timer updated successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($timer, 202);
        }

        return redirect(route('timers.index', $timer->project_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timer  $timer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timer $timer)
    {
        $this->authorize('update', $timer);

        $timer->delete();

        session()->flash('flash', 'The Timer was deleted successfully!');

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('timers.index', $timer->project_id));
    }
}
