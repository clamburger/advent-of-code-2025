<?php

namespace App\Day02;

class StrictRange extends Range
{
    public function isNumberInvalid(int $number): bool
    {
        $numberString = (string)$number;
        return preg_match('/^(.+)\\1+$/', $numberString);
    }
}
