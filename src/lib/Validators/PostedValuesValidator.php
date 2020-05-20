<?php

namespace App\lib\Validators;

use App\lib\Validator;

class PostedValuesValidator extends Validator
{
    protected $values;

    public function isValid($val)
    {
        foreach ($val as $item) {
            if (isset($_POST[$item])) {
                $this->values[$item] = $_POST[$item];
            } else {
                $this->setErrorMessage('La  valeur' . $item . 'est absente.');
                return null;
            }
        }

        return $this->values;
    }
}
