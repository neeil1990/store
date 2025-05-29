<?php

if (!function_exists('mf')) {
    function mf($amount): string
    {
        return money($amount)->format();
    }
}
