<?php

namespace App\lib;

class Validator
{
    public function checkPostedValues($val)
    {
        if (!is_array($val)) {
            return $this->issetVal($_POST[$val]);
        }

        foreach ($val as $item) {
            $posts[$item] = $this->issetVal($_POST[$item]);
        }

        if (in_array(null, $posts)) {
            return null;
        }

        return $posts;
    }

    public function checkString($string)
    {
        if (is_string($string) && strlen($string) >= 3) {
            return true;
        }

        return false;
    }

    public function checkDigit($digit)
    {
        $digit = (int) $digit;

        if (is_int($digit)) {
            return true;
        }

        return false;
    }

    public function checkTwins($a, $b)
    {
        if ($a === $b) {
            return true;
        }

        return false;
    }

    public function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public function issetVal($val)
    {
        if (isset($val)) {
            return $val;
        }

        return null;
    }
}
