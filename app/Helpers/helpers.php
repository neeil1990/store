<?php

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
