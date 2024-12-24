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

    function getPassword(): string
    {
        return $this->password;
    }

    function getName(): string
    {
        return $this->name;
    }

    function getSurname(): string
    {
        return $this->surname;
    }

    function getEmail(): string
    {
        return $this->email;
    }

    function getPhone(): string
    {
        return $this->phone;
    }

    function setLogin(string $login): void
    {
        $this->login = $login;
    }

    function setPassword(string $password): void
    {
        $this->password = $password;
    }

    function setName(string $name): void
    {
        $this->name = $name;
    }

    function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    function setEmail(string $email): void
    {
        $this->email = $email;
    }

    function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}