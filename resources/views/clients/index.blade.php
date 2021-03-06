@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">My Clients</div>
        <div class="mt-1 mx-auto md:m-0">
            <a href="{{ route('clients.create') }}" class="btn is-primary is-small md:is-normal">New Client</a>
        </div>
    </div>
    @if ($clients->count() || session()->has('filters.clients'))
        <filter-panel 
            label="{{ Str::plural('Client', $clients->count()) }}"
            item-count="{{ $clients->count() }}"
            base-url="{{ request()->url() }}"
            :request-object="{{ json_encode(request()->all()) }}" 
            :session-filters="{{ json_encode(session()->get('filters.clients')) }}"
            end-point="clients" 
            :filters="{
                active: {
                    label: 'Active Clients Only',
                    inverse: 'inactive'
                },
                inactive: {
                    label: 'Inactive Clients Only',
                    inverse: 'active'
                }
            }">
            <div slot="content" class="card-container">
                @forelse ($clients as $client)
                    <div class="w-full md:w-1/2 lg:w-1/3 px-2 pb-4">
                        <div class="card flex flex-col">
                            <div class="card-header flex">
                                <div class="flex-1 text-sm sm:text-lg">
                                    <a href="{{ route('projects.index', $client->id) }}" class="text-secondary-dark">{{ $client->name }}</a>
                                    @if (! $client->active)
                                        <span class="warning text-sm">(Inactive)</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn-text is-primary is-small">edit</a>
                                </div>
                            </div>
                            <div class="card-body flex flex-1">
                                <div class="card-detail">
                                    <div class="w-1/3">
                                        <h2>{{ $client->active_project_count }}</h2> 
                                        <span>active<br/>
                                            {{ Str::plural('project', $client->active_project_count) }}
                                        </span>
                                    </div>
                                    <div class="w-1/3">
                                        <h2>{{ $client->all_billable_time }}</h2> 
                                        <span>billable<br/>
                                            {{ Str::plural('hour', $client->all_billable_time) }}
                                        </span>
                                    </div>
                                    <div class="w-1/3">
                                        <h2>{{ $client->all_non_billable_time }}</h2> 
                                        <span>non-billable<br/>
                                            {{ Str::plural('hour', $client->all_non_billable_time) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="p-2 mt-4 mx-auto">
                        There are no Clients matching your filtering options.
                    </p>
                @endforelse
            </div>
        </filter-panel>
    @else
        <p class="p-2 mt-4">
            You currently do not have any Clients. Please <a href="{{ route('clients.create') }}" class="btn-text is-primary">add</a> one.
        </p>
    @endif
</div>
@endsection
