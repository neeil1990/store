<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use App\Models\Setting;

class AppLayout extends Component
{
    protected $menu;

    public static function menuItems(): array
    {
        return [
            'products.index' => ['text' => __('Товары'), 'icon' => 'fas fa-store', 'selected' => ''],
            'products.outOfStock' => ['text' => __('Товары по упущ.выгоде'), 'icon' => 'fas fa-wave-square', 'selected' => ''],
            'suppliers.index' => ['text' => __('Товары к закупке'), 'icon' => 'fas fa-parachute-box', 'selected' => ''],
            'shipper.index' => ['text' => __('Поставщики'), 'icon' => 'fas fa-store-alt', 'selected' => ''],
            'users.index' => ['text' => __('Пользователи'), 'icon' => 'fas fa-users', 'selected' => ''],
            'employee.index' => ['text' => __('Сотрудники (Мой Склад)'), 'icon' => 'fas fa-users', 'selected' => ''],
            'setting.index' => ['text' => __('Настройки'), 'icon' => 'fas fa-tools', 'selected' => ''],
        ];
    }

    public function __construct()
    {
        $route = Route::currentRouteName();

        $this->menu = static::menuItems();

        if(isset($this->menu[$route]))
            $this->menu[$route]['selected'] = 'active';
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $siteTitle = Setting::where('key', 'site_title')->value('value');
        $siteName = Setting::where('key', 'site_name')->value('value');
        $footerPhone = Setting::where('key', 'footer_phone')->value('value');
        $footerTelegram = Setting::where('key', 'footer_telegram')->value('value');
        $showFooterPhone = Setting::where('key', 'show_footer_phone')->value('value') !== '0';
        $showFooterTelegram = Setting::where('key', 'show_footer_telegram')->value('value') !== '0';
        return view('layouts.app', [
            'menu' => $this->menu,
            'siteTitle' => $siteTitle,
            'siteName' => $siteName,
            'footerPhone' => $footerPhone,
            'footerTelegram' => $footerTelegram,
            'showFooterPhone' => $showFooterPhone,
            'showFooterTelegram' => $showFooterTelegram,
        ]);
    }
}
