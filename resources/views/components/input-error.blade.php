@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <span class="d-block error invalid-feedback">{{ $message }}</span>
    @endforeach
@endif
