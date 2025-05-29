<?php

if (!function_exists('money')) {
    function money(float $amount): string
    {
        return number_format($amount, 2, ',' , ' ');
    }
}

if (!function_exists('amount')) {
    function amount(int $amount): string
    {
        return number_format($amount, 0, ',' , ' ');
    }
}
