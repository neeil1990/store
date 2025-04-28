@if ($name)
    <a>{{ $name }}</a>
    <br/>
    <small>{{ $origin_name }}</small>
@else
    <a>{{ $origin_name }}</a>
@endif

