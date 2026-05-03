{{-- Заголовок карточки + иконка подсказки (Bootstrap tooltip) --}}
<div class="d-flex align-items-center flex-wrap setting-card-title-wrap">
    <h3 class="card-title mb-0">{{ $title }}</h3>
    @if(! empty($hint))
        <i
            class="far fa-question-circle text-info ml-2 setting-card-hint-icon"
            data-toggle="tooltip"
            data-placement="bottom"
            data-html="false"
            title="{{ e($hint) }}"
            role="img"
            aria-label="{{ __('Справка по разделу') }}"
            style="cursor: help; font-size: 1rem;"
        ></i>
    @endif
</div>
