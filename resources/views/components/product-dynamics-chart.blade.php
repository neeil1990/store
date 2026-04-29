@props([
    'labels' => [],
    'data' => [],
    'title' => __('Product Count Dynamics'),
])

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="productDynamicsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    $(function () {
        var chartCanvas = $('#productDynamicsChart').get(0).getContext('2d');

        var chartData = {
            labels: @json($labels),
            datasets: [
                {
                    label: '{{ __("Product Count") }}',
                    backgroundColor: 'rgba(60, 141, 188, 0.9)',
                    borderColor: 'rgba(60, 141, 188, 0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60, 141, 188, 1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60, 141, 188, 1)',
                    data: @json($data),
                    fill: false,
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        };

        var chartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    }
                },
                y: {
                    grid: {
                        display: true,
                    },
                    ticks: {
                        beginAtZero: true
                    },
                    title: {
                        display: true,
                        text: '{{ __("Products") }}'
                    }
                }
            }
        };

        new Chart(chartCanvas, {
            type: 'line',
            data: chartData,
            options: chartOptions
        });
    });
</script>
@endpush

