<div {{ $attributes->merge(['class' => 'modal']) }} tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ $action }}" method="{{ $method }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{ $slot }}
                </div>

                <div class="modal-footer">
                    {{ $footer }}
                </div>
            </form>
        </div>
    </div>
</div>
