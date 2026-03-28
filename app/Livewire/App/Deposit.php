<?php

namespace App\Livewire\App;

use App\Application\UseCases\DepositMoneyUseCase;
use App\Infrastructure\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class Deposit extends Component
{
    public string $amount = '';
    public bool $success = false;

    protected function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    protected function messages(): array
    {
        return [
            'amount.required' => 'Informe o valor do depósito.',
            'amount.numeric'  => 'O valor deve ser numérico.',
            'amount.min'      => 'O valor mínimo é R$ 0,01.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'amount' => 'valor',
        ];
    }

    /**
     * @throws Throwable
     */
    public function deposit(DepositMoneyUseCase $depositMoneyUseCase): void
    {
        $this->validate();

        /** @var UserModel $user */
        $user = Auth::user();

        $depositMoneyUseCase->execute(
            accountId: (string) $user->account->id,
            amount: (float) $this->amount
        );

        $this->reset('amount');
        $this->success = true;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.deposit');
    }
}
