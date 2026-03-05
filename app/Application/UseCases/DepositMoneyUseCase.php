<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TransactionEntity;
use App\Domain\Repositories\TransactionRepositoryInterface;
use DomainException;
use Throwable;

readonly class DepositMoneyUseCase
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository
    ) {}

    /**
     * @throws Throwable
     */
    public function execute(string $accountId, float $amount): TransactionEntity
    {
        if ($amount <= 0) {
            throw new DomainException(message: 'O valor do depósito deve ser maior que zero.');
        }

        return $this->transactionRepository->createDeposit(
            accountId: $accountId,
            amount: $amount
        );
    }
}
