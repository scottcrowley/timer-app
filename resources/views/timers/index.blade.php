@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.edit', $project->client->id) }}">{{ $project->client->name }}</a> / 
            <a href="{{ route('projects.index', $project->client->id) }}">Projects</a> / 
            <a href="{{ route('projects.edit', $project->id) }}">{{ $project->name }}</a> / 
            Timers
        </div>
        <div class="mt-1 mx-auto md:m-0">
            <a href="{{ route('timers.create', $project->id) }}" class="btn is-primary is-small md:is-normal">New Timer</a>
        </div>
    </div>
    @if ($timers->count() || session()->has('filters.timers.' . $project->id))
        <timers 
            :timers="{{ $timers }}"
            label="{{ Str::plural('Timer', $timers->count()) }}"
            base-url="{{ request()->url() }}"
            :request-object="{{ json_encode(request()->all()) }}" 
            :session-filters="{{ json_encode(session()->get('filters.timers.' . $project->id)) }}"
            end-point="timers/{{ $project->id }}" 
            :filters="{
                billable: {
                    label: 'Billable Timers Only',
                    inverse: 'nonbillable'
                },
                nonbillable: {
                    label: 'Non-Billable Timers Only',
                    inverse: ['billable', 'billed', 'notbilled']
                },
                billed: {
                    label: 'Billed Timers Only',
                    inverse: ['notbilled', 'nonbillable']
                },
                notbilled: {
                    label: 'Not Billed Timers Only',
                    inverse: ['billed', 'nonbillable']
                }
            }"/>
    @else
        <p class="p-2 mt-4">
            You currently do not have any Timers for the {{ $project->name }} project. Please 
            <a href="{{ route('timers.create', $project->id) }}" class="btn-text is-primary">add</a> one.
        </p>
    @endif
    
</div>
@endsection
