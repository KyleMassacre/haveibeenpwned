<?php

namespace KyleMass\Hibp\Validator;

use Hibp;

class Validator
{
    public function validate($attribute, $value, $parameters)
    {

        // Check password: true
        if (array_get($parameters, '0') == 'true' || ! array_get($parameters, '0')) {
            $return = ! Hibp::hasPasswordBeenPwned($value);
        } // Check account: false
        else {
            $return = ! Hibp::hasAccountBeenPwned($value);
        }

        return $return;
    }
}
