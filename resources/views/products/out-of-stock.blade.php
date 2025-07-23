<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Товары с нулевым остатком') }}</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('products.outOfStock', ['isZero' => 1]) }}" class="btn btn-secondary btn-default btn-sm @if(request('isZero')) active @endif">{{ __('Показать нулевые') }}</a>
                            <a href="{{ route('products.outOfStock') }}" class="btn btn-secondary btn-default btn-sm @if(!request('isZero')) active @endif">{{ __('Показать все') }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="products-zero" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('Наименование') }}</th>
                                        <th>{{ __('Поставщик') }}</th>
                                        <th>{{ __('Артикул') }}</th>
                                        <th>{{ __('Код') }}</th>
                                        <th>{{ __('Закупочная цена') }}</th>
                                        <th>{{ __('Неснижаемый остаток') }}</th>
                                        <th>{{ __('Неснижаемый остаток lager') }}</th>
                                        <th>3</th>
                                        <th>5</th>
                                        <th>7</th>
                                        <th>15</th>
                                        <th>30</th>
                                        <th>60</th>
                                        <th>90</th>
                                        <th>180</th>
                                        <th>365</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-app m-0" target="_blank"><i class="fas fa-folder"></i>{{ $product->id }}</a>
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->suppliers->name }}</td>
                                            <td>{{ $product->article }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->buyPrice }}</td>
                                            <td>{{ $product->minimumBalance }}</td>
                                            <td>{{ $product->minimumBalanceLager }}</td>
                                            <td>{{ $product->stock_zero_3 }}</td>
                                            <td>{{ $product->stock_zero_5 }}</td>
                                            <td>{{ $product->stock_zero_7 }}</td>
                                            <td>{{ $product->stock_zero_15 }}</td>
                                            <td>{{ $product->stock_zero_30 }}</td>
                                            <td>{{ $product->stock_zero_60 }}</td>
                                            <td>{{ $product->stock_zero_90 }}</td>
                                            <td>{{ $product->stock_zero_180 }}</td>
                                            <td>{{ $product->stock_zero_365 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <script>
            $('#products-zero').DataTable({
                language: {
                    lengthMenu: '_MENU_',
                    search: 'Поиск _INPUT_',
                    info: 'Показаны с _START_ до _END_ из _TOTAL_ элементов',
                    paginate: {
                        previous: '<',
                        next: '>',
                    }
                },
                lengthMenu: [100, 150, 200, 250, 300],
            });
        </script>
    @endpush

</x-app-layout>


