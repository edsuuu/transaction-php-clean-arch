<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\AccountEntity;
use App\Domain\Repositories\AccountRepositoryInterface;
use App\Infrastructure\Models\AccountModel;

class AccountRepository implements AccountRepositoryInterface
{
    public function save(AccountEntity $account): AccountEntity
    {
        $accountModel = AccountModel::query()->create(
            ['user_id' => $account->getUserId()],
        );

        return new AccountEntity(
            id: $accountModel->id,
            userId: $accountModel->user_id
        );
    }

    public function findByUserId(int $userId): ?AccountEntity
    {
        $accountModel = AccountModel::query()->where('user_id', $userId)->first();

        if (!$accountModel) {
            return null;
        }

        return new AccountEntity(
            id: $accountModel->id,
            userId: $accountModel->user_id
        );
    }
}
