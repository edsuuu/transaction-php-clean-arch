<?php

namespace App\Domain\Entities;

readonly class TransactionEntity
{
    public function __construct(
        private string $id,
        private string $status,
        private float  $amount,
        private string $createdAt
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'transaction_id' => $this->id,
            'status' => $this->status,
            'amount' => (float) $this->amount,
            'created_at' => $this->createdAt,
        ];
    }
}
