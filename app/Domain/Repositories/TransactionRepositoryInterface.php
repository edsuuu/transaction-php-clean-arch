<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\TransactionEntity;

interface TransactionRepositoryInterface
{
    public function createTransfer(string $payerAccountId, string $payeeAccountId, float $amount): TransactionEntity;
    public function createDeposit(string $accountId, float $amount): TransactionEntity;
    public function findByAccountId(string $accountId): array;
}
