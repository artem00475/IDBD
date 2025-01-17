<?php

namespace classes\db\entity;

class Subscription
{
    private string $plan;
    private string $client;
    private string $startDate;
    private string $finishDate;
    private int $cost;

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    public function getPlan(): string
    {
        return $this->plan;
    }

    public function setPlan(string $plan): void
    {
        $this->plan = $plan;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getFinishDate(): string
    {
        return $this->finishDate;
    }

    public function setFinishDate(string $finishDate): void
    {
        $this->finishDate = $finishDate;
    }
}