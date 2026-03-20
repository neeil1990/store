<x-app-layout>

    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12">
            @can('create user')
                <a href="{{ route('register') }}" class="btn bg-gradient-info">Добавить пользователя</a>
            @endcan
            @if($archived)
                <a href="{{ route('users.index') }}" class="btn bg-gradient-success">Активные пользователи</a>
            @else
                <a href="{{ route('users.index', ['archived' => 1]) }}" class="btn bg-gradient-secondary">Архив пользователей</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Должность/отдел</th>
                                <th>Статус</th>
                                <th>Зарегистрирован</th>
                                @canany(['edit user', 'delete user'])
                                    <th></th>
                                @endcanany
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user['id'] }}</td>
                                <td>
                                    {{ $user['name'] }}
                                    <br />
                                    <small>
                                        {{ __($user->roles->value('name')) }}
                                    </small>
                                </td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['department'] }}</td>
                                <td>
                                    @if($user->is_archived)
                                        <span class="badge badge-secondary">В архиве</span>
                                    @else
                                        <span class="badge badge-success">Активен</span>
                                    @endif
                                </td>
                                <td>{{ $user['created_at']->diffForHumans() }}</td>
                                @canany(['edit user', 'delete user'])
                                <td>
                                    @can('edit user')
                                        <a href="{{ route('users.edit', $user['id']) }}" class="btn bg-gradient-success btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    @endcan

                                    @can('delete user')
                                        <form method="POST" action="{{ route('users.destroy', $user['id']) }}" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить пользователя {{ $user['name'] }}?')">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn bg-gradient-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                </td>
                                @endcanany
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-md-6 -->
    </div>

</x-app-layout>
