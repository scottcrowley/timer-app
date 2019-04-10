@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a> / 
            <a href="{{ route('projects.index', $client->id) }}">Projects</a> / 
            New Project
        </div>
    </div>
    <div class="w-3/4 lg:w-1/2 mx-auto">
        <div class="rounded shadow">
            <div class="bg-white px-6 py-8 rounded">
                
                <form method="POST" action="{{ route('projects.store', $client->id) }}">
                    {{ csrf_field() }}
    
                    <div class="field-group">
                        <label for="name" class="">Project Name</label>
                        <div class="field">
                            <input 
                                name="name" 
                                type="text" 
                                class="{{ $errors->has('name') ? 'border-error-dark' : 'border-secondary-light' }}" 
                                value="{{ old('name') }}" 
                                required autofocus>
                            {!! $errors->first('name', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="description" class="">Description</label>
                        <div class="field">
                            <textarea name="description" id="description" rows="3"></textarea>
                            {!! $errors->first('description', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    @include('layouts._errors')

                    <div class="field-group btn-group">
                        <div class="field">
                            <a href="{{ route('projects.index', $client->id) }}" class="mr-3">Cancel</a>
                            <button type="submit" class="btn is-primary">Add Project</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
