<?php

namespace App\lib\Validators;

use App\lib\Validator;

class EmailValidator extends Validator
{
    public function isValid($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}
