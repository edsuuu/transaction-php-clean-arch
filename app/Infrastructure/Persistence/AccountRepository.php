<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\AccountEntity;
use App\Domain\Repositories\AccountRepositoryInterface;
use App\Infrastructure\Models\AccountModel;

use App\Infrastructure\Models\LedgerEntryModel;
use App\Infrastructure\Models\ReferenceValueModel;
use Illuminate\Support\Facades\DB;

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

        if (is_null($accountModel)) {
            return null;
        }

        return new AccountEntity(
            id: $accountModel->id,
            userId: $accountModel->user_id
        );
    }

    public function getBalance(string $accountId): float
    {
//        $debitId = ReferenceValueModel::query()->where('code', 'debit')->value('id');
        $creditId = ReferenceValueModel::query()->where('code', 'credit')->value('id');

        $balance = LedgerEntryModel::query()
            ->where('account_id', $accountId)
            ->select(columns: DB::raw(value: "
                SUM(
                    CASE
                        WHEN entry_type_id = {$creditId} THEN amount
                        ELSE -amount
                    END
                ) as balance
            "))
            ->value('balance');

        return (float)($balance ?? 0.0);
    }
}
