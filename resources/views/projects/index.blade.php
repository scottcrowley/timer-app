@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1">{{ $client->name .': Projects' }} </div>
        <div>
            <a href="{{ route('projects.create', $client->id) }}" class="btn is-primary">New Project</a>
        </div>
    </div>
    <div class="card-container">
        @forelse ($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                <div class="card">
                    <div class="card-header flex">
                        <div class="flex-1">{{ $project->name }}</div>
                        <div><a href="{{ route('projects.edit', $project->id) }}" class="btn-text is-primary is-small">edit</a></div>
                    </div>
                    <div class="card-body"></div>
                </div>
            </div>
        @empty
            <p class="p-2 mt-4">You currently do not have any Projects for {{ $client->name }}. Please <a href="{{ route('projects.create', $client->id) }}" class="btn-text is-primary">add</a> one.</p>
        @endforelse
    </div>
</div>
@endsection
