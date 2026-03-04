<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Models\UserModel;
use JetBrains\PhpStorm\NoReturn;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?UserEntity
    {
        $userModel = UserModel::query()->find($id);

        if (is_null($userModel)) {
            return null;
        }

        return new UserEntity(
            $userModel->id,
            $userModel->first_name,
            $userModel->last_name,
            $userModel->email,
            $userModel->document,
            $userModel->phone,
            (string) $userModel->birth_date,
            $userModel->customer_type,
            $userModel->password
        );
    }

    public function existsByEmail(string $email): bool
    {
        return UserModel::query()
            ->where('email', $email)
            ->exists();
    }

    public function existsByDocument(string $document): bool
    {
        return UserModel::query()
            ->where('document', $document)
            ->exists();
    }

    public function save(UserEntity $user): UserEntity
    {
        $userModel = UserModel::query()->create(
            [
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'document' => $user->getFormattedDocument(),
                'phone' => $user->getFormattedPhone(),
                'birth_date' => $user->getBirthDate(),
                'customer_type' => $user->detectCustomerType($user->getDocument()),
                'password' => $user->getPassword(),
            ]
        );

        return new UserEntity(
            id: $userModel->id,
             firstName:  $userModel->first_name,
            lastName:  $userModel->last_name,
            email: $userModel->email,
            document: $userModel->document,
            phone: $userModel->phone,
            birthDate: (string) $userModel->birth_date
        );
    }
}
