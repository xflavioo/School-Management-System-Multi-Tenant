<?php

namespace App\Rules;

use App\Helpers\BrazilianFormat;
use Illuminate\Contracts\Validation\Rule;

class ValidCep implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return BrazilianFormat::validateCep($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute deve ser um CEP válido (formato: 00000-000).';
    }
}