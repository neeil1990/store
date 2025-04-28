@props(['label' => 'Info', 'name' => 'input'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'form-control', 'id' => $name, 'name' => $name]) }}>
</div>
