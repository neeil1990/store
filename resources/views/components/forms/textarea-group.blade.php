@props(['label' => 'Info', 'name' => 'input', 'value' => ''])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea {{ $attributes->merge(['class' => 'form-control', 'rows' => '4', 'id' => $name, 'name' => $name]) }}>{{ $value }}</textarea>
</div>
