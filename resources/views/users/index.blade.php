<x-app-layout>

    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12">
            @can('create user')
                <a href="{{ route('register') }}" class="btn bg-gradient-info">Добавить пользователя</a>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Пользователи</h3>
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
                                <td>{{ $user['created_at']->diffForHumans() }}</td>
                                @canany(['edit user', 'delete user'])
                                <td>
                                    @can('edit user')
                                        <a href="{{ route('users.edit', $user['id']) }}" class="btn bg-gradient-success btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    @endcan

                                    @can('delete user')
                                        <form method="POST" action="{{ route('users.destroy', $user['id']) }}" class="d-inline">
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
