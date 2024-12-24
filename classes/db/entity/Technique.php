<?php

namespace classes\db\entity;

class Technique
{
    private int $id;
    private int $clientId;
    private string $date;
    private string $technique;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getTechnique(): string
    {
        return $this->technique;
    }

    public function setTechnique(string $technique): void
    {
        $this->technique = $technique;
    }
}