<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function findById(int $id): ?UserEntity;
    public function existsByDocument(string $document): bool;

    public function findByEmail(string $email): ?UserEntity;

    public function existsByEmail(string $email): bool;

    public function incrementFailedAttempts(int $userId): void;

    public function blockUser(int $userId): void;

    public function resetFailedAttempts(int $userId): void;

    public function createToken(int $userId, string $tokenName): string;

    public function findByAccountId(string $accountId): ?UserEntity;

    public function save(UserEntity $user): UserEntity;
}
