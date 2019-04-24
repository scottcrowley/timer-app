@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row mb-6">
        <div class="title flex-1 font-thin">
            <a href="{{ route('clients.index') }}">My Clients</a> / 
            <a href="{{ route('clients.edit', $project->client->id) }}">{{ $project->client->name }}</a> / 
            <a href="{{ route('projects.index', $project->client->id) }}">Projects</a> / 
            <a href="{{ route('projects.edit', $project->id) }}">{{ $project->name }}</a> / 
            Timers
        </div>
        <div class="mt-1 ml-auto md:m-0">
            <a href="{{ route('timers.create', $project->id) }}" class="btn is-primary is-small md:is-normal">New Timer</a>
        </div>
    </div>
    {{-- <div class="card-container justify-center" style="margin: 0;">
        <div class="w-2/5 card" style="height: auto;">
            <div class="card-body">
                <div class="card-detail">
                    <div class="w-1/4">
                        <h3>{{ $timers->sum('total_billable_time') }}</h3> 
                        <span>billable<br/>
                            {{ Str::plural('hour', $timers->sum('total_billable_time')) }}
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3>{{ $timers->sum('total_non_billable_time') }}</h3> 
                        <span>non-billable<br/>
                            {{ Str::plural('hour', $timers->sum('total_non_billable_time')) }}
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3>{{ $timers->sum('total_billed_time') }}</h3> 
                        <span>{{ Str::plural('hour', $timers->sum('total_billed_time')) }}<br/>
                            billed
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3>{{ $timers->sum('total_not_billed_time') }}</h3> 
                        <span>{{ Str::plural('hour', $timers->sum('total_not_billed_time')) }}<br/>
                            to be billed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @if ($timers->count() || session()->has('filters.timers.' . $project->id))
        <timers inline-template>
            <div>
                <timer-details 
                    billable="{{ $timers->sum('total_billable_time') }}"
                    billable-label="{{ Str::plural('hour', $timers->sum('total_billable_time')) }}"
                    non-billable="{{ $timers->sum('total_non_billable_time') }}"
                    non-billable-label="{{ Str::plural('hour', $timers->sum('total_non_billable_time')) }}"
                    billed="{{ $timers->sum('total_billed_time') }}"
                    billed-label="{{ Str::plural('hour', $timers->sum('total_billed_time')) }}"
                    not-billed="{{ $timers->sum('total_not_billed_time') }}"
                    not-billed-label="{{ Str::plural('hour', $timers->sum('total_not_billed_time')) }}"
                    @updated="updateDetails"
                ></timer-details>

                <filter-panel 
                    label="{{ Str::plural('Timer', $timers->count()) }}"
                    item-count="{{ $timers->count() }}"
                    base-url="{{ request()->url() }}"
                    :request-object="{{ json_encode(request()->all()) }}" 
                    :session-filters="{{ json_encode(session()->get('filters.timers.' . $project->id)) }}"
                    end-point="timers/{{ $project->id }}" 
                    :filters="{
                        billable: {
                            label: 'Billable Timers Only',
                            inverse: 'nonbillable'
                        },
                        nonbillable: {
                            label: 'Non-Billable Timers Only',
                            inverse: ['billable', 'billed', 'notbilled']
                        },
                        billed: {
                            label: 'Billed Timers Only',
                            inverse: ['notbilled', 'nonbillable']
                        },
                        notbilled: {
                            label: 'Not Billed Timers Only',
                            inverse: ['billed', 'nonbillable']
                        }
                    }">
                    <div slot="content" class="card-container">
                        @forelse ($timers as $timer)
                            <timer :timer="{{ $timer }}" :total-time="{{ number_format($timer->total_time, 1) }}" total-time-label="{{ Str::plural('Hour', $timer->total_time) }}"></timer>
                        @empty
                            <p class="p-2 mt-4 mx-auto">
                                There are no Timers matching your filtering options.
                            </p>
                        @endforelse
                    </div>
                </filter-panel>
            </div>
        </timers>
    @else
        <p class="p-2 mt-4">
            You currently do not have any Timers for the {{ $project->name }} project. Please 
            <a href="{{ route('timers.create', $project->id) }}" class="btn-text is-primary">add</a> one.
        </p>
    @endif
    
</div>
@endsection
