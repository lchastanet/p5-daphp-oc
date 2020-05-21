<?php

namespace App\lib\Validators;

use App\lib\Authenticator;
use App\lib\Validator;

class PostedValuesValidator extends Validator
{
    protected $values;

    public function isValid($val)
    {
        $postedValues = $_POST;

        if (array_key_exists('token', $postedValues)) {
            $sessionInfo = Authenticator::getSessionInfo();

            if ($postedValues['token'] == $sessionInfo['token']) {
                foreach ($val as $item) {
                    if (array_key_exists($item, $postedValues)) {
                        $this->values[$item] = $postedValues[$item];
                    } else {
                        $this->setErrorMessage('La  valeur' . $item . 'est absente.');
                        return null;
                    }
                }
                return $this->values;
            } else {
                $this->setErrorMessage('Le token d\'authentification ne correspond pas');
                return null;
            }
        } else {
            $this->setErrorMessage('Le token d\'authentification est absent');
            return null;
        }
    }
}
