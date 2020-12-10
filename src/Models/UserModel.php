<?php

namespace App\Models;

use App\Interfaces\UserEntityInterface;
use App\Interfaces\UserModelInterface;

class UserModel implements UserModelInterface
{
    private $db;

    /**
     * UserModel constructor.
     * @param $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Gets all users from Database
     * @return array contains all active users in DB
     */
    public function getAllUsers(): array
    {
        $query = $this->db->query('SELECT `Firstname`, `Surname`, `DateOfBirth`, `PhoneNumber`, `Email` 
                                                FROM `users` 
                                                WHERE `Deleted` = 0;');

        return $query->fetchAll();
    }

    /**
     * Adds a user to the Database
     * @param UserEntityInterface $userEntity
     * @return bool if user has been added successfully to DB
     */
    public function addUser(UserEntityInterface $userEntity): bool
    {
        $array = [
            "Firstname"=>$userEntity->getFirstname(),
            "Surname"=>$userEntity->getSurname(),
            "DateOfBirth"=>$userEntity->getDateOfBirth(),
            "PhoneNumber"=>$userEntity->getPhoneNumber(),
            "Email"=>$userEntity->getEmail()
        ];

        $query = $this->db->prepare("INSERT INTO `users`
                                        (`Firstname`, `Surname`, `DateOfBirth`, `PhoneNumber`, `Email`)
                                            VALUES (:Firstname, :Surname, :DateOfBirth, :PhoneNumber, :Email)");

        return $query->execute($array);
    }

    /**
     * @return bool if user has been updated successfully in DB
     */
    public function updateUser(UserEntityInterface $userEntity): bool
    {
        $array = [
            "Firstname"=>$userEntity->getFirstname(),
            "Surname"=>$userEntity->getSurname(),
            "DateOfBirth"=>$userEntity->getDateOfBirth(),
            "PhoneNumber"=>$userEntity->getPhoneNumber(),
            "Email"=>$userEntity->getEmail()
        ];

        $query = $this->db->prepare("UPDATE `users`
                                        SET
                                            `FirstName` = :Firstname,
                                            `Surname` = :Surname,
                                            `DateOfBirth` = :DateOfBirth,
                                            `PhoneNumber` = :PhoneNumber,
                                        WHERE `Email` = :Email;");

        return $query->execute($array);
    }

    /**
     * Checks if user exists in Database
     * @param string $Email
     * @return array containing the existing user and deleted status.
     * @return false if user doesn't exist
     */
    public function checkUserExists(string $email)
    {
        $query = $this->db->prepare("SELECT `Email`, `Deleted` FROM `users` WHERE `Email` = ?");
        $query->execute([$email]);
        return $query->fetch();
    }

    /**
     * Soft deletes user from Database
     * @param string $Email
     * @return bool if the operation was successful or not
     */
    public function deleteUserByEmail(string $email): bool
    {
        $query = $this->db->prepare("UPDATE `users`
                                        SET `deleted` = 1
                                        WHERE `Email` = ?");

        return $query->execute([$email]);
    }

}