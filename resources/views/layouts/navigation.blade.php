<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="{{ route('profile.edit') }}" class="d-block">
            {{ Auth::user()->email }}
        </a>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @foreach($menu as $index => $val)
        <li class="nav-item">
            <a href="{{ route($index) }}" class="nav-link {{ $val['selected'] }}"><i class="nav-icon fas fa-users"></i> <p>{{ $val['text'] }}</p></a>
        </li>
        @endforeach

        <li class="nav-item">
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
