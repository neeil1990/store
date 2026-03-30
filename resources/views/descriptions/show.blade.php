<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Описание: {{ $description->key }}</h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $description->key }}</h3>
                </div>
                <div class="card-body">
                    {!! $description->content !!}
                </div>
                <div class="card-footer">
                    <a href="{{ route('descriptions.edit', $description) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('descriptions.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
