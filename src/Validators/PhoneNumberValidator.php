<?php

namespace App\Validators;

class PhoneNumberValidator extends StringValidator
{
    private const PHONE_REGEX = '^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$';
    private const MAX_CHAR = 15;
    private const ERROR_MSG = 'Must provide phoneNumber and be max 15 characters long';

    /**
     * Checks the following:
     *  - That phoneNumber is provided and is max 255 characters.
     *  - That a valid phoneNumber was provided.
     *
     * @param string $phoneNumber
     * @return string|null
     * @throws \Exception
     */
    public static function validatePhoneNumber(string $phoneNumber)
    {
        $phoneNumber = self::validateExistsAndLength($phoneNumber, self::MAX_CHAR, self::ERROR_MSG);

        if (!preg_match(self::PHONE_REGEX, $phoneNumber)) {
            throw new \Exception('Invalid phoneNumber');
        }

        return $phoneNumber;
    }
}