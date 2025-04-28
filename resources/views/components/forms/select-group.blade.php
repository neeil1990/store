@props(['label' => 'Info', 'name' => 'input'])

<div class="form-group">
    <label>{{ $label }}</label>
    <select {{ $attributes->merge(['class' => 'custom-select', 'id' => $name, 'name' => $name]) }}>
        {{ $slot }}
    </select>
</div>
