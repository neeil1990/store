@props([
    'count' => 0,
    'color' => 'bg-success',
    'icon' => 'fas fa-users',
    'label' => 'Users in System',
    'link' => '#'
])

<!-- small box -->
<div class="small-box {{ $color }}">
    <div class="inner">
        <h3>{{ $count }}</h3>
        <p>{{ $label }}</p>
    </div>
    <div class="icon">
        <i class="{{ $icon }}"></i>
    </div>
    <a href="{{ $link }}" class="small-box-footer">
        {{ __('More info') }} <i class="fas fa-arrow-circle-right"></i>
    </a>
</div>

