@props([
    'name',
    'type' => 'text',
    'icon' => 'envelope',
    'placeholder' => '',
    'value' => null,
    'required' => false,
    'autofocus' => false,
    'autocomplete' => null,
])

<div class="mb-3">
    <div class="input-group">
        <input
            id="{{ $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if ($placeholder !== '') placeholder="{{ $placeholder }}" @endif
            {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
            {{ $required ? 'required' : '' }}
            {{ $autofocus ? 'autofocus' : '' }}
            @if (! is_null($autocomplete)) autocomplete="{{ $autocomplete }}" @endif
        >
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-{{ $icon }}"></span>
            </div>
        </div>
    </div>
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
