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

import Sortable from 'sortablejs';
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

/**
 * Фильтр пунктов сайдбара по вводу (без выпадающего списка AdminLTE SidebarSearch).
 */
function initSidebarMenuInlineFilter() {
    const $sidebar = $('.main-sidebar');
    const $input = $sidebar.find('.lp-sidebar-menu-filter-input');
    if (! $input.length) {
        return;
    }

    const $nav = $sidebar.find('.nav-sidebar');
    const $icon = $sidebar.find('.lp-sidebar-menu-filter-icon');

    function applyFilter() {
        const q = ($input.val() || '').toLowerCase().trim();
        $nav.children('li.nav-item').each(function () {
            const $li = $(this);
            if ($li.is('[data-lp-menu-always]')) {
                $li.removeClass('lp-menu-filter-hidden');

                return;
            }
            const $link = $li.children('a.nav-link').first();
            if (! $link.length) {
                return;
            }
            const text = ($link.find('p').first().text() || $link.text() || '').toLowerCase();
            if (q === '' || text.includes(q)) {
                $li.removeClass('lp-menu-filter-hidden');
            } else {
                $li.addClass('lp-menu-filter-hidden');
            }
        });
        if (q === '') {
            $icon.removeClass('fa-times').addClass('fa-search');
        } else {
            $icon.removeClass('fa-search').addClass('fa-times');
        }
    }

    function resetFilter() {
        $input.val('');
        applyFilter();
    }

    $input.on('input', applyFilter);

    $sidebar.find('.lp-sidebar-menu-filter-clear').on('click', function (e) {
        e.preventDefault();
        if (($input.val() || '').trim() !== '') {
            resetFilter();
        }
        $input.trigger('focus');
    });

    $(document).on('collapsed.lte.pushmenu', '[data-widget="pushmenu"]', resetFilter);

    $(document).on('mouseleave', '.main-sidebar', () => {
        if ($('body').hasClass('sidebar-mini') && $('body').hasClass('sidebar-collapse')) {
            resetFilter();
        }
    });
}

$(initSidebarMenuInlineFilter);

document.addEventListener('DOMContentLoaded', () => {
    const menuBody = document.getElementById('sidebar-menu-sortable');
    if (!menuBody) {
        return;
    }

    const reindexMenuRows = () => {
        menuBody.querySelectorAll('tr').forEach((tr, i) => {
            tr.querySelectorAll('[name^="menu_items["]').forEach((el) => {
                el.name = el.name.replace(/menu_items\[\d+\]/, `menu_items[${i}]`);
            });
            const sortInp = tr.querySelector('.sidebar-menu-sort-input');
            if (sortInp) {
                sortInp.value = String(i * 10);
            }
        });
    };

    new Sortable(menuBody, {
        animation: 150,
        handle: '.sidebar-menu-drag-handle',
        draggable: '.sidebar-menu-sort-row',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: reindexMenuRows,
    });

    reindexMenuRows();
});

