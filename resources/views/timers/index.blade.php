@extends('layouts.app')

@section('content')
<div class="w-3/4 lg:w-1/2">
    <div class="rounded shadow">
        <div class="flex font-medium text-lg text-primary-darker bg-primary p-3 rounded-t">
            <div>Timers for {{ $project->name }}</div>
            <div class="ml-auto">
                {{-- <a href="{{ route('timers.create', $project->id) }}" class="btn is-header-btn">Add New</a> --}}
            </div>
        </div>
        <div class="bg-white p-3 pb-6 rounded-b">
            @forelse ($timers as $timer)
                <div class="py-2 px-1 border rounded mt-3 flex text-secondary-darker">
                    <span>{{ $timer->description }}</span>
                    {{-- <a href="{{ route('timers.edit', $timers->project_id) }}" class="ml-auto text-sm">edit</a> --}}
                </div>
            @empty
                <p>There are currently no Timers available for this Project.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
