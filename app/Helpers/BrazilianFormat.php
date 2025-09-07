<?php

namespace App\Helpers;

use Carbon\Carbon;

class BrazilianFormat
{
    /**
     * Format date to Brazilian format (dd/mm/yyyy)
     *
     * @param string|Carbon $date
     * @return string
     */
    public static function date($date)
    {
        if (!$date) {
            return '';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->format('d/m/Y');
    }

    /**
     * Format datetime to Brazilian format (dd/mm/yyyy HH:mm)
     *
     * @param string|Carbon $datetime
     * @return string
     */
    public static function datetime($datetime)
    {
        if (!$datetime) {
            return '';
        }

        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime);
        }

        return $datetime->format('d/m/Y H:i');
    }

    /**
     * Format money to Brazilian format (R$ 1.234,56)
     *
     * @param float|int $value
     * @param int $decimals
     * @return string
     */
    public static function money($value, $decimals = 2)
    {
        if ($value === null || $value === '') {
            return 'R$ 0,00';
        }

        return 'R$ ' . number_format((float) $value, $decimals, ',', '.');
    }

    /**
     * Format CPF (000.000.000-00)
     *
     * @param string $cpf
     * @return string
     */
    public static function cpf($cpf)
    {
        if (!$cpf) {
            return '';
        }

        $cpf = preg_replace('/\D/', '', $cpf);
        
        if (strlen($cpf) !== 11) {
            return $cpf;
        }

        return substr($cpf, 0, 3) . '.' . 
               substr($cpf, 3, 3) . '.' . 
               substr($cpf, 6, 3) . '-' . 
               substr($cpf, 9, 2);
    }

    /**
     * Format CNPJ (00.000.000/0000-00)
     *
     * @param string $cnpj
     * @return string
     */
    public static function cnpj($cnpj)
    {
        if (!$cnpj) {
            return '';
        }

        $cnpj = preg_replace('/\D/', '', $cnpj);
        
        if (strlen($cnpj) !== 14) {
            return $cnpj;
        }

        return substr($cnpj, 0, 2) . '.' . 
               substr($cnpj, 2, 3) . '.' . 
               substr($cnpj, 5, 3) . '/' . 
               substr($cnpj, 8, 4) . '-' . 
               substr($cnpj, 12, 2);
    }

    /**
     * Format CEP (00000-000)
     *
     * @param string $cep
     * @return string
     */
    public static function cep($cep)
    {
        if (!$cep) {
            return '';
        }

        $cep = preg_replace('/\D/', '', $cep);
        
        if (strlen($cep) !== 8) {
            return $cep;
        }

        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }

    /**
     * Format phone with area code ((11) 99999-9999)
     *
     * @param string $phone
     * @return string
     */
    public static function phone($phone)
    {
        if (!$phone) {
            return '';
        }

        $phone = preg_replace('/\D/', '', $phone);
        
        if (strlen($phone) === 11) {
            // Cell phone: (11) 99999-9999
            return '(' . substr($phone, 0, 2) . ') ' . 
                   substr($phone, 2, 5) . '-' . 
                   substr($phone, 7, 4);
        } elseif (strlen($phone) === 10) {
            // Landline: (11) 9999-9999
            return '(' . substr($phone, 0, 2) . ') ' . 
                   substr($phone, 2, 4) . '-' . 
                   substr($phone, 6, 4);
        }

        return $phone;
    }

    /**
     * Validate CPF
     *
     * @param string $cpf
     * @return bool
     */
    public static function validateCpf($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula o primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $cpf[$i] * (10 - $i);
        }
        $firstDigit = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);

        // Calcula o segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $cpf[$i] * (11 - $i);
        }
        $secondDigit = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);

        return $cpf[9] == $firstDigit && $cpf[10] == $secondDigit;
    }

    /**
     * Validate CNPJ
     *
     * @param string $cnpj
     * @return bool
     */
    public static function validateCnpj($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Calcula o primeiro dígito verificador
        $sum = 0;
        $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights[$i];
        }
        $firstDigit = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);

        // Calcula o segundo dígito verificador
        $sum = 0;
        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights[$i];
        }
        $secondDigit = $sum % 11 < 2 ? 0 : 11 - ($sum % 11);

        return $cnpj[12] == $firstDigit && $cnpj[13] == $secondDigit;
    }

    /**
     * Validate CEP format
     *
     * @param string $cep
     * @return bool
     */
    public static function validateCep($cep)
    {
        $cep = preg_replace('/\D/', '', $cep);
        return strlen($cep) === 8 && is_numeric($cep);
    }
}