<?php

namespace classes\db\entity;

class Order
{
    private int $id;
    private string $client;
    private string $technique;
    private string $payment;
    private string $status;
    private string $content;
    private int $cost;
    private string $date;
    private string $master;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    public function getTechnique(): string
    {
        return $this->technique;
    }

    public function setTechnique(string $technique): void
    {
        $this->technique = $technique;
    }

    public function getPayment(): string
    {
        return $this->payment;
    }

    public function setPayment(string $payment): void
    {
        $this->payment = $payment;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getMaster(): string
    {
        return $this->master;
    }

    public function setMaster(string $master): void
    {
        $this->master = $master;
    }
}