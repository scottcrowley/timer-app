@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.edit', $client->id) }}">{{ $client->name }}</a> / 
            Projects
        </div>
        <div class="mt-1 ml-auto md:m-0">
            <a href="{{ route('projects.create', $client->id) }}" class="btn is-primary is-small md:is-normal">New Project</a>
        </div>
    </div>
    @if ($projects->count() || session()->has('filters.projects.' . $client->id))
        <filter-panel 
            label="{{ Str::plural('Project', $projects->count()) }}"
            item-count="{{ $projects->count() }}"
            base-url="{{ request()->url() }}"
            :request-object="{{ json_encode(request()->all()) }}" 
            :session-filters="{{ json_encode(session()->get('filters.projects.' . $client->id)) }}"
            end-point="projects/{{ $client->id }}" 
            :filters="{
                active: {
                    label: 'Active Projects Only',
                    inverse: 'inactive'
                },
                inactive: {
                    label: 'Inactive Projects Only',
                    inverse: 'active'
                }
            }">
            <div slot="content" class="card-container">
                @forelse ($projects as $project)
                    <div class="w-full md:w-1/2 lg:w-1/3 px-3 pb-6">
                        <div class="card flex flex-col" style="height: 14rem;">
                            <div class="card-header flex">
                                <div class="flex-1 text-sm sm:text-lg">
                                    <a href="{{ route('timers.index', $project->id) }}" class="text-secondary-dark">{{ $project->name }}</a>
                                    @if (! $project->active)
                                        <span class="warning text-sm">(Inactive)</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn-text is-primary is-small">edit</a>
                                </div>
                            </div>
                            <div class="card-body flex flex-col flex-1">
                                <p class="text-secondary flex-1">{{ $project->description }}</p>
                                <div class="card-detail">
                                    <div class="w-1/3">
                                        <h3>{{ $project->all_billable_time }}</h3> 
                                        <span>billable<br/>
                                            {{ Str::plural('hour', $project->all_billable_time) }}
                                        </span>
                                    </div>
                                    <div class="w-1/3">
                                        <h3>{{ $project->all_non_billable_time }}</h3> 
                                        <span>non-billable<br/>
                                            {{ Str::plural('hour', $project->all_non_billable_time) }}
                                        </span>
                                    </div>
                                    <div class="w-1/3">
                                        <h3>{{ $project->all_billed_time }}</h3> 
                                        <span>{{ Str::plural('hour', $project->all_billed_time) }}<br/>
                                            billed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="p-2 mt-4 mx-auto">
                        There are no Projects matching your filtering options.
                    </p>
                @endforelse
            </div>
        </filter-panel>
    @else
        <p class="p-2 mt-4">
            You currently do not have any Projects for {{ $client->name }}. Please 
            <a href="{{ route('projects.create', $client->id) }}" class="btn-text is-primary">add</a> one.
        </p>
    @endif
</div>
@endsection
