<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\AccountEntity;

interface AccountRepositoryInterface
{
    public function save(AccountEntity $account): AccountEntity;
    public function findByUserId(int $userId): ?AccountEntity;
    public function getBalance(string $accountId): float;
}
