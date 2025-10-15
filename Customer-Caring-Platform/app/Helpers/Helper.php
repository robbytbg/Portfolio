<?php

namespace App\Helpers;

class Helper
{
    public static function sanitizeSaldo($value)
    {
        // Remove any non-numeric characters
        $sanitized_value = preg_replace('/[^\d]/', '', $value);
        return (int)$sanitized_value;  // Convert to integer
    }
}
