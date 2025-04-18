<?php


namespace App\Services;


class DataTableViewService
{
    public static function minimumBalanceLagerView(?string $value, int $id = null, bool $string = false)
    {
        $view = view('columns.minimum-balance-lager', compact('value', 'id'));

        if ($string) {
            return $view->render();
        }

        return $view;
    }
}
