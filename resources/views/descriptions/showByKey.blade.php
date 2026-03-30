<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Описание: {{ $key }}</h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $key }}</h3>
                </div>
                <div class="card-body">
                    {!! $value ?? '<em>Not found</em>' !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
