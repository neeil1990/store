<span class="badge bg-success" data-toggle="tooltip" title="@includeWhen(count($storages) > 0, 'shippers.partials.storages', compact('storages', 'sumStock', 'minBalance'))">
    {{ $fillByStorageValue }} <i class="far fa-question-circle"></i>
</span>
