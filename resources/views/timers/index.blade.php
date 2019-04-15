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
        <div class="mt-1 ml-auto md:m-0">
            <a href="{{ route('timers.create', $project->id) }}" class="btn is-primary is-small md:is-normal">New Timer</a>
        </div>
    </div>
    @if ($timers->count())
        <filter-panel 
            base-url="{{ request()->url() }}"
            :request-object="{{ json_encode(request()->all()) }}" 
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
            }">
            <div slot="content" class="card-container">
                @foreach ($timers as $timer)
                    <div class="w-full md:w-1/2 lg:w-1/3 px-3 pb-6">
                        <div class="card flex flex-col" style="height: 14rem;">
                            <div class="card-header flex">
                                <div class="flex-1 text-sm sm:text-lg">
                                    <a href="{{ route('timers.show', $timer->id) }}" class="text-secondary-dark">
                                        {{ number_format($timer->total_time, 1) }} Hours
                                    </a>
                                    <p class="font-thin text-xs mt-2">
                                        {{ $timer->start->format('n/j/Y h:i a') . ' - ' . $timer->end->format('n/j/Y h:i a') }}
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('timers.edit', $timer->id) }}" class="btn-text is-primary is-small">edit</a>
                                </div>
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
                @endforeach
            </div>
        </filter-panel>
    @else
        <p class="p-2 mt-4">
            You currently do not have any Timers for the {{ $project->name }} project. Please 
            <a href="{{ route('timers.create', $project->id) }}" class="btn-text is-primary">add</a> one.
        </p>
    @endif
    
</div>
@endsection
