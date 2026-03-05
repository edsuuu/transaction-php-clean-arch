<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\TransactionRepositoryInterface;

readonly class GetTransactionHistoryUseCase
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository
    ) {}

    public function execute(string $accountId): array
    {
        return $this->transactionRepository->findByAccountId($accountId);
    }
}
