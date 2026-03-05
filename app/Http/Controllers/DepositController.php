<?php

namespace App\Http\Controllers;

use App\Application\UseCases\DepositMoneyUseCase;
use App\Http\Requests\DepositRequest;
use App\Http\Resources\TransferResource;
use App\Infrastructure\Models\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class DepositController extends Controller
{
    public function __construct(
        private readonly DepositMoneyUseCase $depositMoneyUseCase
    ) {}

    /**
     * @throws Throwable
     */
    public function store(DepositRequest $request): JsonResponse
    {
        /** @var UserModel $user */
        $user = Auth::user();

        $result = $this->depositMoneyUseCase->execute(
            accountId: (string) $user->account->id,
            amount: (float) $request->amount
        );

        return new TransferResource(resource: $result)
            ->response()
            ->setStatusCode(code: 201);
    }
}
