<?php

namespace App\lib\Validators;

use App\lib\Validator;

class TwinsValidator extends Validator
{
    public function isValid($a, $b)
    {
        if ($a === $b) {
            return true;
        }

        return false;
    }
}
