<?php

namespace App\lib\Validators;

use App\lib\Authenticator;
use App\lib\Validator;

class PostedValuesValidator extends Validator
{
    protected $values;

    public function isValid($val)
    {
        if (isset($_POST['token'])) {
            $sessionInfo = Authenticator::getSessionInfo();

            if ($_POST['token'] == $sessionInfo['token']) {
                foreach ($val as $item) {
                    if (isset($_POST[$item])) {
                        $this->values[$item] = $_POST[$item];
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
