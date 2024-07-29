<?php

use Illuminate\Support\Str;

if (!function_exists('create_slug')) {
    function create_slug($string)
    {
        return Str::slug($string, '-');
    }
}
