import './bootstrap';
import 'admin-lte';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

import generator from 'generate-password-browser';

$('#generate-password').click(function () {

    const password = generator.generate({
        length: 12,
        numbers: true,
        symbols: true
    });

    $($(this).data('class')).val(password);
});

function tooltip($node = null, title = '')
{
    if (!$node) {
        $node = $('[data-toggle="tooltip"]');
    }

    $node.tooltip({
        'html': true,
        'title': title
    });
}

window.tooltip = tooltip;

tooltip();



