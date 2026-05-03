<div class="card">
    <div class="card-header">
        @include('setting.partials.card-title-with-hint', [
            'title' => __('Меню сайдбара'),
            'hint' => __('Настраивается левое меню для всех пользователей: подписи, иконки (классы Font Awesome), показ пункта и порядок строк. Список разделов задан в приложении из соображений безопасности; можно менять только представление. Перетаскивайте строки за иконку слева, затем нажмите «Сохранить меню».'),
        ])
    </div>
    <form method="post" action="{{ route('setting.updateSidebarMenu') }}">
        @csrf
        <div class="card-body">
            @if(session('status') === 'setting-sidebar-menu')
                <div class="callout callout-success alert-dismissible mb-3">
                    <p>{{ __('Меню сохранено.') }}</p>
                </div>
            @endif
            <p class="text-muted small mb-3">
                {{ __('Перетащите строки за иконку слева, чтобы изменить порядок в меню. Иконки пунктов: классы Font Awesome, например fas fa-store.') }}
            </p>
            @if ($errors->has('menu_items'))
                <div class="alert alert-danger">{{ $errors->first('menu_items') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 2.5rem" class="text-center" title="{{ __('Перетащить') }}"></th>
                            <th style="width: 14rem">{{ __('Маршрут') }}</th>
                            <th>{{ __('Название в меню') }}</th>
                            <th style="width: 12rem">{{ __('Иконка') }}</th>
                            <th style="width: 6rem" class="text-center">{{ __('Показ') }}</th>
                        </tr>
                    </thead>
                    <tbody id="sidebar-menu-sortable">
                        @foreach($sidebarMenuRows as $idx => $row)
                            <tr class="sidebar-menu-sort-row">
                                <td class="text-center align-middle">
                                    <span class="sidebar-menu-drag-handle text-muted" title="{{ __('Перетащить') }}">
                                        <i class="fas fa-grip-vertical"></i>
                                    </span>
                                    <input type="hidden" name="menu_items[{{ $idx }}][sort]" class="sidebar-menu-sort-input"
                                           value="{{ old('menu_items.'.$idx.'.sort', $row['sort']) }}">
                                </td>
                                <td>
                                    <input type="hidden" name="menu_items[{{ $idx }}][route]" value="{{ $row['route'] }}">
                                    <code class="small">{{ $row['route'] }}</code>
                                </td>
                                <td>
                                    <input type="text" name="menu_items[{{ $idx }}][label]" class="form-control form-control-sm"
                                           value="{{ old('menu_items.'.$idx.'.label', $row['label']) }}" maxlength="120" required>
                                </td>
                                <td>
                                    <input type="text" name="menu_items[{{ $idx }}][icon]" class="form-control form-control-sm"
                                           value="{{ old('menu_items.'.$idx.'.icon', $row['icon']) }}" maxlength="80" required>
                                </td>
                                <td class="text-center">
                                    @if(! empty($row['force_visible']))
                                        <input type="hidden" name="menu_items[{{ $idx }}][enabled]" value="1">
                                        <input type="checkbox" class="form-check-input m-0" checked disabled
                                               title="{{ __('Всегда в меню') }}">
                                    @else
                                        <input type="hidden" name="menu_items[{{ $idx }}][enabled]" value="0">
                                        <input type="checkbox" name="menu_items[{{ $idx }}][enabled]" value="1"
                                               class="form-check-input m-0" style="position: relative"
                                               {{ old('menu_items.'.$idx.'.enabled', $row['enabled'] ? '1' : '0') === '1' ? 'checked' : '' }}>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <x-primary-button type="submit">{{ __('Сохранить меню') }}</x-primary-button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .sidebar-menu-drag-handle {
        cursor: grab;
        display: inline-flex;
        padding: 0.35rem 0.25rem;
        user-select: none;
    }
    .sidebar-menu-drag-handle:active {
        cursor: grabbing;
    }
    .sidebar-menu-sort-row.sortable-chosen {
        background-color: #f8f9fa;
    }
    .sidebar-menu-sort-row.sortable-ghost {
        opacity: 0.45;
    }
</style>
@endpush
