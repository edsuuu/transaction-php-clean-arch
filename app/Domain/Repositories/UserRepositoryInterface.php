<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function findById(int $id): ?UserEntity;
    public function existsByDocument(string $document): bool;

    public function existsByEmail(string $email): bool;

    public function save(UserEntity $user): UserEntity;
}
