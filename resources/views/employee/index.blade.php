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
                <div class="card-header d-flex align-items-center flex-wrap">
                    <h3 class="card-title mb-0">{{ $pageTitle }}</h3>
                    <span class="ml-auto small">
                        <a href="{{ route('employee.listV2', request()->only('archived')) }}" class="text-muted">{{ __('Версия New') }}</a>
                    </span>
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
                        @foreach($employees as $user)
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
                    <div class="card-footer clearfix">
                        {{ $employees->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-md-6 -->
    </div>

</x-app-layout>
