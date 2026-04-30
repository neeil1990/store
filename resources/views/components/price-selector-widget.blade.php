@props([
    'priceNames' => [],
    'color' => 'bg-primary',
    'icon' => 'fas fa-tag'
])

<div class="small-box {{ $color }}">
    <div class="inner">
        <h3 id="price-sum">{{ money(0) }}</h3>
        <p class="mb-5"></p>
        <div class="form-group mb-0">
            <select id="price-select" class="form-control form-control-sm">
                <option value="">-- {{ __('Choose price') }} --</option>
                @foreach($priceNames as $price)
                    <option value="{{ $price }}">{{ $price }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="icon">
        <i class="{{ $icon }}"></i>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            const priceSelect = $('#price-select');
            const priceSum = $('#price-sum');

            priceSelect.on('change', function() {
                const priceName = $(this).val();

                axios.get("{{ route('dashboard.price-sum') }}", {
                    params: {
                        price_name: priceName
                    }
                })
                    .then(function(response) {
                        priceSum.text(response.data.formatted_sum);
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        priceSum.text('{{ __("Error") }}');
                    });
            });
        });
    </script>
@endpush

