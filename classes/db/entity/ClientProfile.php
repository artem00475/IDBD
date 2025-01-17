<?php

namespace classes\db\entity;
class ClientProfile
{
    private int $userId;
    private string $address;
    private string $photo;

    function getUserId(): int
    {
        return $this->userId;
    }

    function setUserId(int $id): void
    {
        $this->userId = $id;
    }

    function getAddress(): string
    {
        return $this->address;
    }

    function setAddress(string $address): void
    {
        $this->address = $address;
    }

    function getPhoto(): string
    {
        return $this->photo;
    }

    function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }
}