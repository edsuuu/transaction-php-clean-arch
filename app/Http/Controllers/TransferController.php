<?php

namespace App\Http\Controllers;

use App\Application\UseCases\TransferMoneyUseCase;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\TransferResource;
use App\Infrastructure\Models\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TransferController extends Controller
{
    public function __construct(
        private readonly TransferMoneyUseCase $transferMoneyUseCase
    ) {}

    /**
     * @throws Throwable
     */
    public function store(TransferRequest $request): JsonResponse
    {
        /** @var UserModel $user */
        $user = Auth::user();

        $result = $this->transferMoneyUseCase->execute(
            payerAccountId: (string) $user->account->id,
            payeeAccountId: $request->payee_account_id,
            amount: (float) $request->amount
        );

        return new TransferResource(resource: $result)
            ->response()
            ->setStatusCode(code: 201);
    }
}
