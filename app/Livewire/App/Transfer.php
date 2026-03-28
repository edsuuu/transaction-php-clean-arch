<?php

namespace App\Livewire\App;

use App\Application\UseCases\TransferMoneyUseCase;
use App\Infrastructure\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class Transfer extends Component
{
    public string $payee_account_id = '';
    public string $amount           = '';
    public bool $success            = false;
    public string $errorMessage     = '';

    protected function rules(): array
    {
        return [
            'payee_account_id' => ['required', 'string', 'uuid'],
            'amount'           => ['required', 'numeric', 'min:0.01'],
        ];
    }

    protected function messages(): array
    {
        return [
            'payee_account_id.required' => 'O ID da conta destino é obrigatório.',
            'payee_account_id.uuid'     => 'Informe um ID de conta válido (formato UUID).',
            'amount.required'           => 'Informe o valor da transferência.',
            'amount.numeric'            => 'O valor deve ser numérico.',
            'amount.min'                => 'O valor mínimo para transferência é R$ 0,01.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'payee_account_id' => 'conta destino',
            'amount'           => 'valor',
        ];
    }

    /**
     * @throws Throwable
     */
    public function transfer(TransferMoneyUseCase $transferMoneyUseCase): void
    {
        $this->errorMessage = '';
        $this->validate();

        /** @var UserModel $user */
        $user = Auth::user();

        try {
            $transferMoneyUseCase->execute(
                payerAccountId: (string) $user->account->id,
                payeeAccountId: $this->payee_account_id,
                amount: (float) $this->amount
            );

            $this->reset('payee_account_id', 'amount');
            $this->success = true;
        } catch (\DomainException $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.transfer');
    }
}
