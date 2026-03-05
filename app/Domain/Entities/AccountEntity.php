<?php

namespace App\Domain\Entities;

readonly class AccountEntity
{
    public function __construct(
        private ?string $id,
        private int     $userId,
    ) {}

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
