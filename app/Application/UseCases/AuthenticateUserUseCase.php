<?php

namespace App\Application\UseCases;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Throwable;

readonly class AuthenticateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function execute(string $email, string $password): UserEntity
    {
        $throttleKey = strtolower(string: $email) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts(key: $throttleKey, maxAttempts: 5)) {
            throw ValidationException::withMessages(messages: [
                'email' => __(key: 'auth.throttle', replace: [
                    'seconds' => RateLimiter::availableIn(key: $throttleKey),
                ]),
            ]);
        }

        $user = $this->userRepository->findByEmail(email: $email);

        if (!$user) {
            RateLimiter::hit(key: $throttleKey);
            throw ValidationException::withMessages(messages: [
                'email' => __(key: 'auth.failed'),
            ]);
        }

        if ($user->isBlocked()) {
            throw ValidationException::withMessages(messages: [
                'email' => 'Sua conta está bloqueada devido a múltiplas tentativas falhas.',
            ]);
        }

        if (!Hash::check(value: $password, hashedValue: $user->getPassword())) {
            $this->userRepository->incrementFailedAttempts(userId: $user->getId());
            RateLimiter::hit(key: $throttleKey);

            if ($user->getFailedLoginAttempts() + 1 >= 3) {
                $this->userRepository->blockUser(userId: $user->getId());
            }

            throw ValidationException::withMessages(messages: [
                'email' => __(key: 'auth.failed'),
            ]);
        }

        $this->userRepository->resetFailedAttempts(userId: $user->getId());

        RateLimiter::clear(key: $throttleKey);

        return $user;
    }
}
