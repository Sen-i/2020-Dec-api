<?php

namespace App\Entities;

use App\Validators\DateValidator;
use App\Validators\NameValidator;
use App\Validators\EmailValidator;
use App\Interfaces\UserEntityInterface;
use App\Validators\PhoneNumberValidator;


class UserEntity implements UserEntityInterface
{
    private $firstname;
    private $surname;
    private $dateOfBirth;
    private $phoneNumber;
    private $email;

    /**
     * UserEntity constructor.
     * @param $firstname
     * @param $surname
     * @param $dateOfBirth
     * @param $phoneNumber
     * @param $email
     */
    public function __construct($firstname, $surname, $dateOfBirth, $phoneNumber, $email)
    {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->dateOfBirth = $dateOfBirth;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;

        $this->validateUser();
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    private function validateUser()
    {
        $this->firstname = NameValidator::validateName($this->firstname);
        $this->surname = NameValidator::validateName($this->surname);
        $this->dateOfBirth = DateValidator::validateDate($this->dateOfBirth);
        $this->stockLevel = PhoneNumberValidator::validatePhoneNumber($this->phoneNumber);
        $this->stockLevel = EmailValidator::validateEmail($this->email);
    }
}