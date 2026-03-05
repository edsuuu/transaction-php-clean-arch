<?php

namespace App\Application\UseCases;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\AccountRepositoryInterface;
use App\Domain\Entities\AccountEntity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DomainException;
use Throwable;

readonly class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AccountRepositoryInterface $accountRepository
    ) {}

    /**
     * @throws Throwable
     */
    public function execute(object $data): UserEntity
    {
        return DB::transaction(callback: function () use ($data) {
            $hashedPassword = Hash::make(value: $data->password);

            $user = new UserEntity(
                id: null,
                firstName: $data->first_name,
                lastName: $data->last_name,
                email: $data->email,
                document: $data->document,
                phone: $data->phone,
                birthDate: $data->birth_date,
                password: $hashedPassword
            );

            if ($this->userRepository->existsByEmail(email: $user->getEmail())) {
                throw new DomainException('Email already exists');
            }

            if ($this->userRepository->existsByDocument(document: $user->getFormattedDocument())) {
                throw new DomainException('Document already exists');
            }

            $createdUser = $this->userRepository->save(user: $user);

            $account = new AccountEntity(
                id: null,
                userId: $createdUser->getId()
            );

            $this->accountRepository->save(account: $account);

            return $createdUser;
        });
    }
}
