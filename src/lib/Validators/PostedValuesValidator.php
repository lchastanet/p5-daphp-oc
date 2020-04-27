<?php

namespace App\lib\Validators;

use App\lib\Validator;

class PostedValuesValidator extends Validator
{
    protected $values;

    public function isValid($val)
    {
        foreach ($val as $item) {
            if (isset($_POST[$item]) == null) {
                $this->setErrorMessage('La  valeur' . $item . 'est absente.');
                return null;
            }

            $this->values[$item] = $_POST[$item];
        }

        return $this->values;
    }
}
