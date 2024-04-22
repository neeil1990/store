<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class AppLayout extends Component
{
    protected $menu;

    public function __construct()
    {
        $route = Route::currentRouteName();

        $this->menu = [
            'users.index' => ['text' => __('Пользователи'), 'icon' => 'fas fa-users', 'selected' => ''],
            'employee.index' => ['text' => __('Сотрудники'), 'icon' => 'fas fa-users', 'selected' => ''],
            'products.index' => ['text' => __('Товары'), 'icon' => 'fas fa-store', 'selected' => ''],
            'setting.index' => ['text' => __('Настройки'), 'icon' => 'fas fa-tools', 'selected' => ''],
        ];

        if(isset($this->menu[$route]))
            $this->menu[$route]['selected'] = 'active';
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app', ['menu' => $this->menu]);
    }
}
