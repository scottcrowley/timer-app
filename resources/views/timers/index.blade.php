@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1">{{ $project->client->name . ': '. $project->name .': Timers' }} </div>
        <div>
            <a href="{{ route('timers.create', $project->id) }}" class="btn is-primary">New Timer</a>
        </div>
    </div>
    <div class="card-container">
        @forelse ($timers as $timer)
            <div class="w-1/3 px-3 pb-6">
                <div class="card">
                    <div class="card-header flex">
                        <div class="flex-1">
                            {{ number_format($timer->total_time, 1) }} Hours
                            <p class="font-thin text-xs mt-2">{{ $timer->start->format('n/j/Y h:i:s a') . ' - ' . $timer->end->format('n/j/Y h:i:s a') }}</p>
                        </div>
                        <div><a href="{{ route('timers.edit', $timer->id) }}" class="btn-text is-primary is-small">edit</a></div>
                    </div>
                    <div class="card-body">
                            {{ $timer->description }}
                    </div>
                </div>
            </div>
        @empty
            <p class="p-2 mt-4">You currently do not have any Timers for the {{ $project->name }} project. Please <a href="{{ route('timers.create', $project->id) }}" class="btn-text is-primary">add</a> one.</p>
        @endforelse
    </div>
</div>
{{-- <div class="w-3/4 lg:w-1/2">
    <div class="rounded shadow">
        <div class="flex font-medium text-lg text-primary-darker bg-primary p-3 rounded-t">
            <div>Timers for {{ $project->name }}</div>
            <div class="ml-auto">
                <a href="{{ route('timers.create', $project->id) }}" class="btn is-header-btn">Add New</a>
            </div>
        </div>
        <div class="bg-white p-3 pb-6 rounded-b">
            @forelse ($timers as $timer)
                <div class="py-2 px-1 border rounded mt-3 flex text-secondary-darker">
                    <span>{{ $timer->description }}</span>
                    <a href="{{ route('timers.edit', $timers->project_id) }}" class="ml-auto text-sm">edit</a>
                </div>
            @empty
                <p>There are currently no Timers available for this Project.</p>
            @endforelse
        </div>
    </div>
</div> --}}
@endsection
