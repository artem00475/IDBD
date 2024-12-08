<?php
namespace classes\db\entity;
class MasterProfile
{
    private int $userId;
    private float $rating;
    private string $photo;
    private float $experience;
    private string $qualification;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getExperience(): float
    {
        return $this->experience;
    }

    public function setExperience(float $experience): void
    {
        $this->experience = $experience;
    }

    public function getQualification(): string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): void
    {
        $this->qualification = $qualification;
    }

}