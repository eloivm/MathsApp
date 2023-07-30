<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;


class DniRule implements Rule
{

    public function passes($attribute, $value)
    {
        if (preg_match('/^([0-9]{8})([A-Z])$/', $value, $matches)) {
            $numbers = $matches[1];
            $letter = $matches[2];

            $valid_letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
            $expected_letter = $valid_letters[$numbers % 23];

            return $letter === $expected_letter;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'El DNI proporcionado no es válido.';
    }
}
