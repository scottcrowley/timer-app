@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a> / 
            <a href="{{ route('projects.index', $client->id) }}">Projects</a> / 
            New Project
        </div>
    </div>
    <div class="w-full md:w-3/4 lg:w-1/2 mx-auto">
        <div class="rounded shadow">
            <div class="bg-white px-6 py-8 rounded">
                
                <form method="POST" action="{{ route('projects.store', $client->id) }}">
                    @include('projects._form', ['project' => new \App\Project(), 'buttonText' => 'Add'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
