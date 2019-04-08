@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex mb-6">
        <div class="title flex-1 font-thin">My Clients</div>
        <div>
            <a href="{{ route('clients.create') }}" class="btn is-primary">New Client</a>
        </div>
    </div>
    <div class="card-container">
        @forelse ($clients as $client)
            <div class="w-1/3 px-3 pb-6">
                <div class="card">
                    <div class="card-header flex">
                        <div class="flex-1">
                            <a href="{{ route('projects.index', $client->id) }}" class="text-secondary-dark">{{ $client->name }}</a>
                        </div>
                        <div>
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn-text is-primary is-small">edit</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><span class="font-semibold">{{ $client->project_count }}</span> active {{ Str::plural('project', $client->project_count) }}</p>
                        <p><span class="font-semibold">{{ $client->all_billable_time }}</span> billable {{ Str::plural('hour', $client->all_billable_time) }}</p>
                        <p><span class="font-semibold">{{ $client->all_non_billable_time }}</span> non-billable {{ Str::plural('hour', $client->all_non_billable_time) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="p-2 mt-4">You currently do not have any Clients. Please <a href="{{ route('clients.create') }}" class="btn-text is-primary">add</a> one.</p>
        @endforelse
    </div>
</div>
@endsection
