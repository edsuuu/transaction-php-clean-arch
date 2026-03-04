<?php

namespace App\Http\Controllers;

use App\Application\UseCases\CreateUserUseCase;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase
    ) {}

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->createUserUseCase->execute((object) $request->validated());

        return new UserResource($user)
            ->response()
            ->setStatusCode(201);
    }
}
