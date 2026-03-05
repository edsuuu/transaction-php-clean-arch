<?php

namespace App\Application\UseCases;

use App\Domain\Entities\TransactionEntity;
use App\Domain\Repositories\AccountRepositoryInterface;
use App\Domain\Repositories\TransactionRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use DomainException;
use Throwable;

readonly class TransferMoneyUseCase
{
    public function __construct(
        private AccountRepositoryInterface     $accountRepository,
        private TransactionRepositoryInterface $transactionRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * @throws Throwable
     */
    public function execute(string $payerAccountId, string $payeeAccountId, float $amount): TransactionEntity
    {
        $user = $this->userRepository->findByAccountId(accountId: $payerAccountId);

        if (!$user) {
            throw new DomainException(message: 'Usuário remetente não encontrado.');
        }

        if ($user->getCustomerType() === 'merchant') {
            throw new DomainException(message: 'Lojistas não podem realizar transferências, apenas receber.');
        }

        if ($amount <= 0) {
            throw new DomainException(message: 'O valor da transferência deve ser maior que zero.');
        }

        if ($payerAccountId === $payeeAccountId) {
            throw new DomainException(message: 'Não é possível transferir para a mesma conta.');
        }

        $currentBalance = $this->accountRepository->getBalance(accountId: $payerAccountId);

        if ($currentBalance < $amount) {
            throw new DomainException(message: 'Saldo insuficiente para realizar a transferência.');
        }

        return $this->transactionRepository->createTransfer(
            payerAccountId: $payerAccountId,
            payeeAccountId: $payeeAccountId,
            amount: $amount
        );
    }
}
