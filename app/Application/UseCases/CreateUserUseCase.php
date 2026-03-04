<?php

namespace App\Application\UseCases;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use DomainException;

readonly class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
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

        // todo: adicionar exceptions personalidazas e converter para http no handle
        if ($this->userRepository->existsByEmail($user->getEmail())) {
            throw new DomainException('Email already exists');
        }

        if ($this->userRepository->existsByDocument($user->getFormattedDocument())) {
            throw new DomainException('Document already exists');
        }

        return $this->userRepository->save($user);
    }
}
