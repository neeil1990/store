@if ($suppliers && $buyers)
<div class="btn-group">
    @if ($suppliers)
        <a title="Экспорт для поставщика" data-toggle="tooltip" href="{{ $suppliers }}" class="btn btn-light btn-sm">
            <i class="fas fa-parachute-box"></i>
        </a>
    @endif

    @if ($buyers)
        <a title="Экспорт для закупщиков" data-toggle="tooltip" href="{{ $buyers }}" class="btn btn-light btn-sm">
            <i class="fas fa-store"></i>
        </a>
    @endif
</div>
@else
    -
@endif

