@if ($filter['error'])
    <small class="badge badge-warning">{{ $filter['error'] }}</small>
@else
    <small class="badge badge-success">{{ $filter['description'] }}</small>
@endif

