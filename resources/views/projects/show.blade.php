@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.show', $project->client->id) }}">{{ $project->client->name }}</a> / 
            <a href="{{ route('projects.index', $project->client->id) }}">Projects</a> / 
            {{ $project->name }}
        </div>
        <div>
            <a href="{{ route('projects.edit', $project->id) }}" class="btn is-primary">Edit Project</a>
        </div>
    </div>
    <div class="w-full md:w-3/4 lg:w-1/2">
        <div class="rounded shadow">
            <div class="flex font-medium text-lg text-primary-darker bg-primary p-3 rounded-t">
                <div>{{ $project->name }}</div>
            </div>
            <div class="bg-white p-3 pb-6 rounded-b">
                
            </div>
        </div>
    </div>
</div>
@endsection
