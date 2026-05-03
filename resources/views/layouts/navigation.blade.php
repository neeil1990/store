<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="{{ route('profile.edit') }}" class="d-block">
            {{ Auth::user()->name }}
        </a>
    </div>
</div>

<div class="form-inline lp-sidebar-menu-search">
    <div class="input-group lp-sidebar-menu-filter" data-lp-sidebar-menu-filter="1">
        <input class="form-control form-control-sidebar lp-sidebar-menu-filter-input" type="search" autocomplete="off" placeholder="{{ __('Фильтр пунктов меню') }}" aria-label="{{ __('Фильтр пунктов меню') }}">
        <div class="input-group-append">
            <button class="btn btn-sidebar lp-sidebar-menu-filter-clear" type="button" title="{{ __('Очистить') }}" aria-label="{{ __('Очистить фильтр') }}">
                <i class="fas fa-search fa-fw lp-sidebar-menu-filter-icon"></i>
            </button>
        </div>
    </div>
</div>

{{-- Дублируем стили поиска по меню: работает даже без актуальной сборки Vite (adminlte скрывает поле/кнопку в sidebar-collapse) --}}
<style>
    .main-sidebar .lp-sidebar-menu-search { padding-left: 0.5rem; padding-right: 0.5rem; }
    .main-sidebar .lp-sidebar-menu-search .input-group { width: 100%; }
    @media (min-width: 992px) {
        body.sidebar-mini:not(.sidebar-collapse) .lp-sidebar-menu-search .input-group {
            display: flex; flex-wrap: nowrap; align-items: stretch;
        }
        body.sidebar-mini:not(.sidebar-collapse) .lp-sidebar-menu-search .form-control-sidebar {
            display: block !important; flex: 1 1 auto; min-width: 0;
        }
        body.sidebar-mini:not(.sidebar-collapse) .lp-sidebar-menu-search .form-control-sidebar ~ .input-group-append {
            display: flex !important; margin-left: 0 !important;
        }
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(:hover):not(.sidebar-focused) .lp-sidebar-menu-search .input-group {
            width: 100%; justify-content: center;
        }
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(:hover):not(.sidebar-focused) .lp-sidebar-menu-search .form-control-sidebar {
            display: none !important;
        }
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(:hover):not(.sidebar-focused) .lp-sidebar-menu-search .form-control-sidebar ~ .input-group-append {
            display: flex !important; width: 100%; margin-left: 0 !important; justify-content: center;
        }
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(:hover):not(.sidebar-focused) .lp-sidebar-menu-search .btn.btn-sidebar {
            border-radius: 0.25rem;
        }
        /* Свёрнут, но наведён на сайдбар: body всё ещё .sidebar-collapse — без этого AdminLTE снова прячет и поле, и лупу */
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(.sidebar-no-expand):hover .lp-sidebar-menu-search .input-group,
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(.sidebar-no-expand).sidebar-focused .lp-sidebar-menu-search .input-group {
            display: flex !important;
            flex-wrap: nowrap;
            align-items: stretch;
            width: 100%;
        }
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(.sidebar-no-expand):hover .lp-sidebar-menu-search .form-control-sidebar,
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(.sidebar-no-expand).sidebar-focused .lp-sidebar-menu-search .form-control-sidebar {
            display: block !important;
            flex: 1 1 auto;
            min-width: 0;
        }
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(.sidebar-no-expand):hover .lp-sidebar-menu-search .form-control-sidebar ~ .input-group-append,
        body.sidebar-mini.sidebar-collapse .main-sidebar:not(.sidebar-no-expand).sidebar-focused .lp-sidebar-menu-search .form-control-sidebar ~ .input-group-append {
            display: flex !important;
            margin-left: 0 !important;
            width: auto;
            justify-content: center;
        }
    }
</style>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @foreach($menu as $index => $val)
        <li class="nav-item">
            <a href="{{ route($index) }}" class="nav-link {{ $val['selected'] }}"><i class="nav-icon {{ $val['icon'] }}"></i> <p>{{ $val['text'] }}</p></a>
        </li>
        @endforeach

        <li class="nav-item" data-lp-menu-always="1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();this.closest('form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Выход</p>
                </a>
            </form>
        </li>
    </ul>
</nav>
