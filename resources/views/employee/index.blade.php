<x-app-layout>

    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12">
            @if($archived)
                <a href="{{ route('employee.index') }}" class="btn bg-gradient-success">Активные сотрудники</a>
            @else
                <a href="{{ route('employee.index', ['archived' => 1]) }}" class="btn bg-gradient-secondary">Архив сотрудников</a>
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
                            <th>ФИО</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employee as $user)
                            <tr>
                                <td>{{ $user['externalCode'] }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['fullName'] }}</td>
                                <td>
                                    @if($user->archived)
                                        <span class="badge badge-secondary">В архиве</span>
                                    @else
                                        <span class="badge badge-success">Активен</span>
                                    @endif
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
