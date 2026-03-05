<?php

namespace App\Http\Controllers;

use App\Application\UseCases\RegisterUserUseCase;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private readonly RegisterUserUseCase $registerUserUseCase
    ) {}

    /**
     * @throws Throwable
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->registerUserUseCase->execute((object) $request->validated());

        return new UserResource($user)
            ->response()
            ->setStatusCode(201);
    }
}
