<?php


namespace App\Services;


class DataTableViewService
{
    public static function columnInputView(array $data, bool $string = false)
    {
        $view = view('columns.input-column', $data);

        if ($string) {
            return $view->render();
        }

        return $view;
    }
}
