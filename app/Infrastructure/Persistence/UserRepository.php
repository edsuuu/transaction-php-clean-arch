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
            id: $userModel->id,
            firstName: $userModel->first_name,
            lastName: $userModel->last_name,
            email: $userModel->email,
            document: $userModel->document,
            phone: $userModel->phone,
            birthDate: (string) $userModel->birth_date,
            password: $userModel->password
        );
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $userModel = UserModel::query()->where('email', $email)->first();

        if (is_null($userModel)) {
            return null;
        }

        return new UserEntity(
            id: $userModel->id,
            firstName: $userModel->first_name,
            lastName: $userModel->last_name,
            email: $userModel->email,
            document: $userModel->document,
            phone: $userModel->phone,
            birthDate: (string) $userModel->birth_date,
            password: $userModel->password,
            failedLoginAttempts: (int) $userModel->failed_login_attempts,
            blockedAt: $userModel->blocked_at ? (string) $userModel->blocked_at : null
        );
    }

    public function incrementFailedAttempts(int $userId): void
    {
        UserModel::query()->where( 'id', $userId)->increment( 'failed_login_attempts');
    }

    public function blockUser(int $userId): void
    {
        UserModel::query()->where( 'id', $userId)->update(['blocked_at' => now()]);
    }

    public function resetFailedAttempts(int $userId): void
    {
        UserModel::query()->where( 'id', $userId)->update(['failed_login_attempts' => 0]);
    }

    public function createToken(int $userId, string $tokenName): string
    {
        /** @var UserModel $userModel */
        $userModel = UserModel::query()->findOrFail(id: $userId);
        return $userModel->createToken(name: $tokenName)->plainTextToken;
    }

    public function existsByEmail(string $email): bool
    {
        return UserModel::query()
            ->where( 'email', $email)
            ->exists();
    }

    public function existsByDocument(string $document): bool
    {
        return UserModel::query()
            ->where( 'document', $document)
            ->exists();
    }

    public function findByAccountId(string $accountId): ?UserEntity
    {
        $userModel = UserModel::query()
            ->join('accounts', 'users.id','=','accounts.user_id')
            ->where( 'accounts.id', $accountId)
            ->select(columns: 'users.*')
            ->first();

        if (is_null($userModel)) {
            return null;
        }

        return new UserEntity(
            id: $userModel->id,
            firstName: $userModel->first_name,
            lastName: $userModel->last_name,
            email: $userModel->email,
            document: $userModel->document,
            phone: $userModel->phone,
            birthDate: (string) $userModel->birth_date,
            password: $userModel->password,
            failedLoginAttempts: (int) $userModel->failed_login_attempts,
            blockedAt: $userModel->blocked_at ? (string) $userModel->blocked_at : null
        );
    }

    public function save(UserEntity $user): UserEntity
    {
        $userModel = UserModel::query()->create([
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
