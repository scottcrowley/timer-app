@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col justify-around h-full">
        <div class="rounded shadow">
            <div class="font-medium text-lg text-primary-darker bg-primary p-3 rounded-t">
                Dashboard
            </div>
            <div class="bg-white p-3 rounded-b">
                @if (session('status'))
                    <div class="bg-secondary-lightest border border-secondary-light text-secondary-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <p class="text-grey-dark">
                    You are logged in!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
