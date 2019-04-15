@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            {{ $client->name }}
        </div>
    </div>
    <div class="w-full md:w-3/4 lg:w-1/2 mx-auto">
        <div class="rounded shadow">
            <div class="bg-white px-6 py-8 rounded">
                
                <form class="form-horizontal" method="POST" action="{{ route('clients.update', $client->id) }}">
                    @include('clients._form', ['client' => $client, 'buttonText' => 'Update'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
