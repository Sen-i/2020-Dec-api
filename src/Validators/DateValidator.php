<?php

namespace App\Validators;

class DateValidator extends StringValidator
{
    private const DATE_REGEX = '(?<=\D|^)(?<year>\d{4})(?<sep>[^\w\s])(?<month>1[0-2]|0[1-9])\k<sep>(?<day>0[1-9]|[12][0-9]|(?<=11\k<sep>|[^1][4-9]\k<sep>)30|(?<=1[02]\k<sep>|[^1][13578]\k<sep>)3[01])(?=\D|$)';
    private const MAX_CHAR = 10;
    private const ERROR_MSG = 'Must provide Date and be less than 10 characters';

    /**
     * Ensures valid 
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function validateDate(string $date)
    {
        if (preg_match(self::DATE_REGEX, $date)) {
            return self::validateExistsAndLength($date, self::MAX_CHAR, self::ERROR_MSG);
        } else {
            throw new \Exception('Invalid date');
        }
    }
}