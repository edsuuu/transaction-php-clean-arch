<?php

namespace App\Http\Controllers;

use App\Application\UseCases\GetBalanceUseCase;
use App\Application\UseCases\GetTransactionHistoryUseCase;
use App\Http\Resources\BalanceResource;
use App\Http\Resources\TransactionResource;
use App\Infrastructure\Models\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct(
        private readonly GetBalanceUseCase $getBalanceUseCase,
        private readonly GetTransactionHistoryUseCase $getTransactionHistoryUseCase
    ) {}

    public function balance(): JsonResponse
    {
        /** @var UserModel $user */
        $user = Auth::user();

        $balance = $this->getBalanceUseCase->execute(
            accountId: (string) $user->account->id
        );

        return (new BalanceResource($balance))
            ->response();
    }

    public function history(): JsonResponse
    {
        /** @var UserModel $user */
        $user = Auth::user();

        $history = $this->getTransactionHistoryUseCase->execute(
            accountId: (string) $user->account->id
        );

        return TransactionResource::collection($history)
            ->response();
    }
}
