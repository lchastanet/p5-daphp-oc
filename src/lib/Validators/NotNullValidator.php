<?php

namespace App\lib\Validators;

use App\lib\Validator;

class NotNullValidator extends Validator
{
    public function isValid($value)
    {
        return $value != '';
    }
}
