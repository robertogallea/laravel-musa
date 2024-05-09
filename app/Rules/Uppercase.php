<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class Uppercase implements DataAwareRule, ValidationRule
{
    private $data;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // la regola richiede che tutti i caratteri del titolo siano in maiuscolo
        //  solo se il contenuto supera i 100 caratteri

        if (strlen($this->data['body']) > 100) {
            // se la versione in maiuscolo dell'attributo è diverso da se stesso
            if (strtoupper($value) !== $value) {
                $fail('Se il contenuto del post supera i 100 caratteri il :attribute deve essere in maiuscolo');
//                $fail('validation.uppercase')->translate([
////                'attribute' => 'testo testo'
//                ], 'en');
            }
        }

    }

    public function setData(array $data)
    {
        $this->data = $data;
    }
}
