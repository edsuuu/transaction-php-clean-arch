<?php

namespace App\Application\UseCases;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(object $data): UserEntity
    {
        $hashedPassword = Hash::make($data->password);

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

        $this->userRepository->save($user);

        return $user;
    }
}
