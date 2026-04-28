<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-lg-3 col-6">
            <x-user-count-widget
                :count="$usersCount"
                color="bg-success"
                icon="fas fa-users"
                label="{{ __('Users in System') }}"
                link="{{ route('users.index') }}"
            />
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-6">
            <x-user-count-widget
                :count="$productsCount"
                color="bg-primary"
                icon="fas fa-box"
                label="{{ __('Products in System') }}"
                link="{{ route('products.index') }}"
            />
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-6">
            <x-user-count-widget
                :count="$suppliersCount"
                color="bg-warning"
                icon="fas fa-store"
                label="{{ __('Suppliers in System') }}"
                link="{{ route('shipper.index') }}"
            />
        </div>
        <!-- /.col -->
    </div>

</x-app-layout>
