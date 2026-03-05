<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\AccountRepositoryInterface;

readonly class GetBalanceUseCase
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository
    ) {}

    public function execute(string $accountId): float
    {
        return $this->accountRepository->getBalance($accountId);
    }
}
