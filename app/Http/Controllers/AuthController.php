<?php

namespace App\Http\Controllers;

use App\Application\UseCases\AuthenticateUserUseCase;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthenticateUserUseCase $authenticateUserUseCase,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authenticateUserUseCase->execute(
            email: $request->email,
            password: $request->password
        );

        $resource = new UserResource(resource: $user);

        if (($request->source ?? 'api') === 'api') {
            $token = $this->userRepository->createToken(userId: $user->getId(), tokenName: 'auth_token');

            return $resource->additional(data: [
                'token' => $token,
                'token_type' => 'Bearer',
            ])->response()
                ->setStatusCode(code: 200);
        }

        return $resource
            ->response()
            ->setStatusCode(code: 200);
    }
}
