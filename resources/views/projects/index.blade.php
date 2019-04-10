@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.edit', $client->id) }}">{{ $client->name }}</a> / 
            Projects
        </div>
        <div>
            <a href="{{ route('projects.create', $client->id) }}" class="btn is-primary">New Project</a>
        </div>
    </div>
    <div class="card-container">
        @forelse ($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                <div class="card flex flex-col" style="height: 14rem;">
                    <div class="card-header flex">
                        <div class="flex-1">
                            <a href="{{ route('timers.index', $project->id) }}" class="text-secondary-dark">{{ $project->name }}</a>
                            @if (! $project->active)
                                <span class="warning text-sm">(Inactive)</span>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn-text is-primary is-small">edit</a>
                        </div>
                    </div>
                    <div class="card-body flex flex-col flex-1">
                        <p class="text-secondary flex-1">{{ $project->description }}</p>
                        <p>
                            <span class="font-semibold">{{ $project->all_billable_time }}</span> 
                            billable {{ Str::plural('hour', $project->all_billable_time) }}
                        </p>
                        <p>
                            <span class="font-semibold">{{ $project->all_non_billable_time }}</span> 
                            non-billable {{ Str::plural('hour', $project->all_non_billable_time) }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="p-2 mt-4">
                You currently do not have any Projects for {{ $client->name }}. Please <a href="{{ route('projects.create', $client->id) }}" class="btn-text is-primary">add</a> one.
            </p>
        @endforelse
    </div>
</div>
@endsection
