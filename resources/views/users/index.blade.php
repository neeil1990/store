<x-app-layout>

    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12">
            <a href="{{ route('register') }}" class="btn bg-gradient-info">Добавить пользователя</a>
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
                                <th>Зарегистрирован</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user['id'] }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['created_at']->diffForHumans() }}</td>
                                <td><a href="{{ route('users.edit', $user['id']) }}" class="btn bg-gradient-success"><i class="fas fa-edit"></i> Редактировать</a></td>
                                <td>
                                    <form method="POST" action="{{ route('users.destroy', $user['id']) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn bg-gradient-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
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
