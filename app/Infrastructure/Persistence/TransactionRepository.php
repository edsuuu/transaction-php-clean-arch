<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\TransactionEntity;
use App\Domain\Repositories\TransactionRepositoryInterface;
use App\Infrastructure\Models\LedgerEntryModel;
use App\Infrastructure\Models\ReferenceValueModel;
use App\Infrastructure\Models\TransactionModel;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function createTransfer(string $payerAccountId, string $payeeAccountId, float $amount): TransactionEntity
    {
        return DB::transaction(callback: function () use ($payerAccountId, $payeeAccountId, $amount) {
            $transferTypeId = ReferenceValueModel::query()->where('code', 'transfer')->first()->id;
            $completedStatusId = ReferenceValueModel::query()->where('code', 'completed')->first()->id;
            $debitTypeId = ReferenceValueModel::query()->where('code', 'debit')->first()->id;
            $creditTypeId = ReferenceValueModel::query()->where('code', 'credit')->first()->id;

            $transaction = TransactionModel::query()->create(attributes: [
                'transaction_type_id' => $transferTypeId,
                'transaction_status_id' => $completedStatusId,
            ]);

            LedgerEntryModel::query()->create(attributes: [
                'transaction_id' => $transaction->id,
                'account_id' => $payerAccountId,
                'entry_type_id' => $debitTypeId,
                'amount' => $amount,
            ]);

            LedgerEntryModel::query()->create(attributes: [
                'transaction_id' => $transaction->id,
                'account_id' => $payeeAccountId,
                'entry_type_id' => $creditTypeId,
                'amount' => $amount,
            ]);

            return new TransactionEntity(
                id: $transaction->id,
                status: 'completed',
                amount: $amount,
                createdAt: (string)$transaction->created_at
            );
        });
    }

    public function createDeposit(string $accountId, float $amount): TransactionEntity
    {
        return DB::transaction(callback: function () use ($accountId, $amount) {
            $depositTypeId = ReferenceValueModel::query()->where('code', 'deposit')->orWhere('code', 'deposito')->first()->id;
            $completedStatusId = ReferenceValueModel::query()->where('code', 'completed')->first()->id;
            $creditTypeId = ReferenceValueModel::query()->where('code', 'credit')->first()->id;

            $transaction = TransactionModel::query()->create(attributes: [
                'transaction_type_id' => $depositTypeId,
                'transaction_status_id' => $completedStatusId,
            ]);

            LedgerEntryModel::query()->create(attributes: [
                'transaction_id' => $transaction->id,
                'account_id' => $accountId,
                'entry_type_id' => $creditTypeId,
                'amount' => $amount,
            ]);

            return new TransactionEntity(
                id: $transaction->id,
                status: 'completed',
                amount: $amount,
                createdAt: (string)$transaction->created_at
            );
        });
    }

    public function findByAccountId(string $accountId): array
    {
        return LedgerEntryModel::query()
            ->with(['transaction.type', 'entryType'])
            ->where('account_id', $accountId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(LedgerEntryModel $entry) => [
                'transaction_id' => $entry->transaction_id,
                'type' => $entry->transaction->type->code,
                'entry_type' => $entry->entryType->code,
                'amount' => (float)$entry->amount,
                'created_at' => (string)$entry->created_at,
            ])
            ->toArray();
    }
}
