@if ($name)
    <a><i class="nav-icon far fa-circle text-success" data-toggle="tooltip" title="{{ __('Поставщик создан') }}"></i> {{ $name }}</a>
@else
    <a><i class="nav-icon far fa-circle text-warning" data-toggle="tooltip" title="{{ __('Данные Мой склад') }}"></i> {{ $old_name }}</a>
@endif

