<?php

use App\Models\Products;

if (!function_exists('money')) {
    function money(float $amount): string
    {
        return number_format($amount, 2, '.' , ' ');
    }
}

if (!function_exists('amount')) {
    function amount(int $amount): string
    {
        return number_format($amount, 0, '.' , ' ');
    }
}

if (!function_exists('convertBoolToStrings')) {
    function convertBoolToStrings(array $data): array
    {
        array_walk_recursive($data, function (&$value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
        });
        return $data;
    }
}

if (!function_exists('stockZeros')) {
    function stockZeros(Products $product, int $days): array
    {
        $carbon = \Carbon\Carbon::now()->subDays($days);

        return [
            'count' => $product->stockTotal()->where('created_at', '>', $carbon)->count(),
            'dateFrom' => $carbon->format('d.m.Y H:i:s')
        ];
    }
}

