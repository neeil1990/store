<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row mb-2">
        <div class="col-12">
            <a href="{{ route('descriptions.create') }}" class="btn btn-success">Создать</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Настройка описания</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Key</th>
                            <th>Content</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->key }}</td>
                                <td>{{ Str::limit(strip_tags($item->content), 80) }}</td>
                                <td>
                                    <a href="{{ route('descriptions.show', $item) }}" class="btn btn-sm btn-info">Show</a>
                                    <a href="{{ route('descriptions.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('descriptions.destroy', $item) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

