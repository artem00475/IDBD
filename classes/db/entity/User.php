<?php

namespace classes\db\entity;

class User
{
    private string $login;
    private string $password;
    private string $name;
    private string $surname;
    private string $email;
    private string $phone;

    function getLogin(): string
    {
        return $this->login;
    }

    function setLogin(string $login): void
    {
        $this->login = $login;
    }

    function getPassword(): string
    {
        return $this->password;
    }

    function setPassword(string $password): void
    {
        $this->password = $password;
    }

    function getName(): string
    {
        return $this->name;
    }

    function setName(string $name): void
    {
        $this->name = $name;
    }

    function getSurname(): string
    {
        return $this->surname;
    }

    function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    function getEmail(): string
    {
        return $this->email;
    }

    function setEmail(string $email): void
    {
        $this->email = $email;
    }

    function getPhone(): string
    {
        return $this->phone;
    }

    function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}