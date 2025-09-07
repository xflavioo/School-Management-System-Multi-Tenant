<?php

namespace App\Support;

use NumberFormatter;
use Carbon\Carbon;
use Illuminate\Support\Str;

final class BrFormat 
{
    /**
     * Format date to Brazilian format (dd/mm/yyyy)
     *
     * @param mixed $value
     * @return string
     */
    public static function date($value): string 
    {
        if (!$value) return '';
        $carbon = $value instanceof Carbon ? $value : Carbon::parse($value);
        
        // Try to get timezone from config, fallback to default
        try {
            $timezone = function_exists('config') && app()->bound('config') 
                ? config('app.timezone', 'America/Sao_Paulo') 
                : 'America/Sao_Paulo';
        } catch (\Exception $e) {
            $timezone = 'America/Sao_Paulo';
        }
        
        return $carbon->timezone($timezone)->format('d/m/Y');
    }

    /**
     * Format datetime to Brazilian format (dd/mm/yyyy HH:mm)
     *
     * @param mixed $value
     * @return string
     */
    public static function datetime($value): string 
    {
        if (!$value) return '';
        $carbon = $value instanceof Carbon ? $value : Carbon::parse($value);
        
        // Try to get timezone from config, fallback to default
        try {
            $timezone = function_exists('config') && app()->bound('config') 
                ? config('app.timezone', 'America/Sao_Paulo') 
                : 'America/Sao_Paulo';
        } catch (\Exception $e) {
            $timezone = 'America/Sao_Paulo';
        }
        
        return $carbon->timezone($timezone)->format('d/m/Y H:i');
    }

    /**
     * Format money to Brazilian format (R$ 1.234,56)
     *
     * @param mixed $value
     * @return string
     */
    public static function money($value): string 
    {
        if ($value === null) return '';
        if (class_exists(NumberFormatter::class)) {
            $fmt = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
            $formatted = $fmt->formatCurrency((float)$value, 'BRL');
            // Replace non-breaking space with regular space for consistency
            return str_replace("\xC2\xA0", ' ', $formatted);
        }
        return 'R$ '.number_format((float)$value, 2, ',', '.');
    }

    /**
     * Format number to Brazilian format (1.234,56)
     *
     * @param mixed $value
     * @param int $decimals
     * @return string
     */
    public static function number($value, int $decimals = 2): string 
    {
        if ($value === null) return '';
        return number_format((float)$value, $decimals, ',', '.');
    }
}