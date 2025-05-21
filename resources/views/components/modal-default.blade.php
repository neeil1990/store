@props(['modal' => 'modal-default', 'title' => "", 'body' => "", 'action' => ''])

<div class="modal fade" id="{{ $modal }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{!! $title !!}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ $action }}" method="POST">
                @csrf

                <div class="modal-body">{!! $body !!}</div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Закрыть') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
