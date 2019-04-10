@if (count($errors))
    <div class="field-group">
        <ul class="danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif