@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            {{ $client->name }}
        </div>
        <div>
            <a href="{{ route('clients.edit', $client->id) }}" class="btn is-primary">Edit Client</a>
        </div>
    </div>
    <div class="w-3/4 lg:w-1/2">
        <div class="rounded shadow">
            <div class="flex font-medium text-lg text-primary-darker bg-primary p-3 rounded-t">
                <div>{{ $client->name }}</div>
            </div>
            <div class="bg-white p-3 pb-6 rounded-b">
                
            </div>
        </div>
    </div>
</div>
@endsection
