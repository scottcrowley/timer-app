@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.show', $project->client->id) }}">{{ $project->client->name }}</a> / 
            <a href="{{ route('projects.index', $project->client->id) }}">Projects</a> / 
            <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a> / 
            <a href="{{ route('timers.index', $project->id) }}">Timers</a> / 
            New Timer
        </div>
    </div>
    <div class="w-3/4 lg:w-1/2 mx-auto">
        <div class="rounded shadow">
            <div class="bg-white px-6 py-8 rounded">
                
                <form method="POST" action="{{ route('timers.store', $project->id) }}">
                    {{ csrf_field() }}
    
                    <div class="field-group">
                        <label for="description">Description</label>
                        <div class="field">
                            <textarea name="description" id="description" rows="3"></textarea>
                            {!! $errors->first('description', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="field-group">
                        <label for="start">Start Time</label>
                        <div class="field">
                            <input 
                                name="start" 
                                type="datetime" 
                                class="{{ $errors->has('start') ? 'border-error-dark' : 'border-secondary-light' }}" 
                                value="{{ old('start') }}" 
                                required autofocus>
                            {!! $errors->first('start', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="field-group">
                        <label for="end">End Time</label>
                        <div class="field">
                            <input 
                                name="end" 
                                type="datetime" 
                                class="{{ $errors->has('end') ? 'border-error-dark' : 'border-secondary-light' }}" 
                                value="{{ old('end') }}" 
                                required autofocus>
                            {!! $errors->first('end', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    @include('layouts._errors')

                    <div class="field-group btn-group">
                        <div class="field">
                            <a href="{{ route('timers.index', $project->id) }}" class="mr-3">Cancel</a>
                            <button type="submit" class="btn is-primary">Add Timer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
