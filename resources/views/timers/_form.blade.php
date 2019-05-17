{{ csrf_field() }}
    
<div class="field-group">
    <label for="description">Description</label>
    <div class="field">
        <textarea name="description" id="description" rows="3">{{ old('description', $timer->description) }}</textarea>
        {!! $errors->first('description', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
    </div>
</div>

<div class="field-group">
    <label for="start">Start Time</label>
    <div class="field">
        <date-time 
            name="start" 
            value="{{ old('start', $timer->start) }}"
            error="{{ $errors->has('start') ? true : false }}" 
            error-message="{{ $errors->first('start') }}">
        </date-time>
    </div>
</div>

<div class="field-group">
    <label for="end">End Time</label>
    <div class="field">
        <date-time 
            name="end" 
            value="{{ old('end', $timer->end) }}" 
            error="{{ $errors->has('end') ? true : false }}" 
            error-message="{{ $errors->first('end') }}">
        </date-time>
    </div>
</div>

<div class="field-group">
    <label for="billable">Billable</label>
    <div class="field">
        <div class="relative">
            <select name="billable" class="w-full">
                <option value="1" {{ (old('billable', $timer->billable) || ($buttonText == 'Add' && old('billable') === null)) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (! old('billable', $timer->billable)) ? 'selected' : '' }}>No</option>
            </select>
            <div class="select-menu-icon">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        {!! $errors->first('billable', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
    </div>
</div>

<div class="field-group">
    <label for="billed">Billed</label>
    <div class="field">
        <div class="relative">
            <select name="billed" class="w-full">
                <option value="1" {{ (old('billed', $timer->billed)) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (! old('billed', $timer->billed)) ? 'selected' : '' }}>No</option>
            </select>
            <div class="select-menu-icon">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        {!! $errors->first('billed', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
    </div>
</div>

@include('layouts._errors')

<div class="field-group btn-group">
    <div class="field w-full justify-end">
        @if ($buttonText == 'Update')
            <delete-confirm-button 
                label="Delete" 
                :data-set="{{ $timer }}" 
                classes="btn is-outlined" 
                path="/timers" 
                message="Are you sure you want to delete this Timer? This action is not undoable."
                title="Are You Sure?"
            >
            </delete-confirm-button>
        @endif
        <a href="{{ ($buttonText == 'Add') ? route('timers.index', $project->id) : route('timers.index', $timer->project_id) }}" class="mr-3 btn is-outlined">Cancel</a>
        <button type="submit" class="btn is-primary">{{ $buttonText }} Timer</button>
    </div>
</div>