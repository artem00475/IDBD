<?php

namespace classes\db\handler\impl;

use classes\db\DBPostgres;
use classes\db\entity\User;
use classes\db\handler\UserHandler;
use PDO;

class UserHandlerImpl implements UserHandler
{

    function add(User $object): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT create_user(:login, :password, :name, :surname, :email, :phone)');
        $stmt->bindValue(':login', $object->getLogin());
        $stmt->bindValue(':password', $object->getPassword());
        $stmt->bindValue(':name', $object->getName());
        $stmt->bindValue(':surname', $object->getSurname());
        $stmt->bindValue(':email', $object->getEmail());
        $stmt->bindValue(':phone', $object->getPhone());
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['create_user']) {
            $obj['create_user'] = trim($obj['create_user'], '()');
            $ar = explode(",", $obj['create_user']);
            return $ar[0] ?: 0;
        } else {
            return 0;
        }
    }

    function update(int $id, User $object): bool
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT update_user(:id, :login, :password, :name, :surname, :email, :phone)');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':login', $object->getLogin());
        $stmt->bindValue(':password', $object->getPassword());
        $stmt->bindValue(':name', $object->getName());
        $stmt->bindValue(':surname', $object->getSurname());
        $stmt->bindValue(':email', $object->getEmail());
        $stmt->bindValue(':phone', $object->getPhone());
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['update_user']) {
            return true;
        } else {
            return false;
        }
    }

    function getById(int $id): User|null
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT get_user(:id)');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($obj['get_user']) {
            $obj['get_user'] = trim($obj['get_user'], '()');
            $ar = explode(",", $obj['get_user']);
            $user = new User();
            $user->setLogin($ar[0]);
            $user->setName($ar[1]);
            $user->setSurname($ar[2]);
            $user->setEmail($ar[3]);
            $user->setPhone($ar[4]);
            $user->setPassword($ar[5]);
            return $user;
        } else {
            return null;
        }
    }

    function authorize(string $login, string $password): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT check_password(:login, :password)');
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['check_password']) {
            $obj['check_password'] = trim($obj['check_password'], '()');
            $ar = explode(",", $obj['check_password']);
            return $ar[0] ?: 0;
        } else {
            return 0;
        }
    }
}