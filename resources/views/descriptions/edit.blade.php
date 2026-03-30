<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактировать описание</h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('descriptions.update', $description) }}" method="POST">
                        @method('PUT')
                        @include('descriptions._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
