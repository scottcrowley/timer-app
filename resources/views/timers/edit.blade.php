@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.show', $timer->project->client->id) }}">{{ $timer->project->client->name }}</a> / 
            <a href="{{ route('projects.index', $timer->project->client->id) }}">Projects</a> / 
            <a href="{{ route('projects.show', $timer->project->id) }}">{{ $timer->project->name }}</a> / 
            <a href="{{ route('timers.index', $timer->project->id) }}">Timers</a> / 
            {{ $timer->description }}
        </div>
    </div>
    <div class="w-3/4 lg:w-1/2">
        <div class="rounded shadow">
            <div class="flex font-medium text-lg text-primary-darker bg-primary p-3 rounded-t">
                <div>Edit {{ $timer->description }}</div>
            </div>
            <div class="bg-white p-3 pb-6 rounded-b">
                
            </div>
        </div>
    </div>
</div>
@endsection
