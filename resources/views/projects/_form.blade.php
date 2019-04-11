{{ csrf_field() }}
    
<div class="field-group">
    <label for="name" class="">Project Name</label>
    <div class="field">
        <input 
            name="name" 
            type="text" 
            class="{{ $errors->has('name') ? 'border-error-dark' : 'border-secondary-light' }}" 
            value="{{ old('name', $project->name) }}" 
            required autofocus>
        {!! $errors->first('name', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
    </div>
</div>

<div class="field-group">
    <label for="description" class="">Description</label>
    <div class="field">
        <textarea name="description" id="description" rows="3">{{ old('description', $project->description) }}</textarea>
        {!! $errors->first('description', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
    </div>
</div>

@if ($buttonText == 'Update')
    <div class="field-group">
        <label for="name" class="w-24">Active</label>
        <div class="field">
            <div class="relative">
                <select name="active" class="w-full">
                    <option value="0" {{ (! old('active', $project->active)) ? 'selected' : '' }}>No</option>
                    <option value="1" {{ (old('active', $project->active)) ? 'selected' : '' }}>Yes</option>
                </select>
                <div class="select-menu-icon">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
            {!! $errors->first('active', '<span class="text-error-dark text-sm mt-2">:message</span>') !!}
        </div>
    </div>
@endif

@include('layouts._errors')

<div class="field-group btn-group">
    <div class="field w-full justify-end">
        @if ($buttonText == 'Update')
            <delete-confirm-button label="Delete" :data-set="{{ $project }}" classes="" path="/projects">
                <div slot="title">Are You Sure?</div>  
                Are you sure you want to delete this Project? All associated Timers will also be deleted. This action is not undoable.
            </delete-confirm-button>
        @endif
        <a href="{{ ($buttonText == 'Add') ? route('projects.index', $client->id) : route('projects.index', $project->client_id) }}" class="mr-3">Cancel</a>
        <button type="submit" class="btn is-primary">{{ $buttonText }} Project</button>
    </div>
</div>