@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.show', $project->client->id) }}">{{ $project->client->name }}</a> / 
            <a href="{{ route('projects.index', $project->client->id) }}">Projects</a> / 
            <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a> / 
            Timers
        </div>
        <div>
            <a href="{{ route('timers.create', $project->id) }}" class="btn is-primary">New Timer</a>
        </div>
    </div>
    <div class="card-container">
        @forelse ($timers as $timer)
            <div class="w-1/3 px-3 pb-6">
                <div class="card flex flex-col" style="height: 14rem;">
                    <div class="card-header flex">
                        <div class="flex-1">
                            <a href="{{ route('timers.show', $timer->id) }}" class="text-secondary-dark">
                                {{ number_format($timer->total_time, 1) }} Hours
                            </a>
                            <p class="font-thin text-xs mt-2">{{ $timer->start->format('n/j/Y h:i:s a') . ' - ' . $timer->end->format('n/j/Y h:i:s a') }}</p>
                        </div>
                        <div><a href="{{ route('timers.edit', $timer->id) }}" class="btn-text is-primary is-small">edit</a></div>
                    </div>
                    <div class="card-body flex flex-col flex-1">
                        <p class="text-secondary flex-1">{{ $timer->description }}</p>
                        @if ($timer->billable)
                            
                            @if ($timer->billed)
                                <p class="text-success">Billed</p>
                            @else
                                <p class="text-blue">Not Yet Billed</p>
                            @endif
                        @else
                            <p class="text-blue">Non-Billable</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="p-2 mt-4">You currently do not have any Timers for the {{ $project->name }} project. Please <a href="{{ route('timers.create', $project->id) }}" class="btn-text is-primary">add</a> one.</p>
        @endforelse
    </div>
</div>
@endsection
