<?php

namespace App\Livewire\App;

use App\Application\UseCases\GetBalanceUseCase;
use App\Application\UseCases\GetTransactionHistoryUseCase;
use App\Infrastructure\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public string $balance = '0.00';
    public array $recentTransactions = [];

    public function mount(
        GetBalanceUseCase $getBalanceUseCase,
        GetTransactionHistoryUseCase $getTransactionHistoryUseCase
    ): void {
        /** @var UserModel $user */
        $user = Auth::user();

        $accountId = (string) $user->account->id;

        $rawBalance = $getBalanceUseCase->execute(accountId: $accountId);
        $this->balance = number_format((float) $rawBalance, 2, '.', '');

        $history = $getTransactionHistoryUseCase->execute(accountId: $accountId);
        $this->recentTransactions = collect($history)->take(5)->all();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.dashboard');
    }
}
