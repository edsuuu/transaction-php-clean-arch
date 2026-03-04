<?php

namespace App\Domain\Entities;

readonly class AccountEntity
{
    public function __construct(
        private ?int  $id,
        private int   $userId,
        private float $balance
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}
