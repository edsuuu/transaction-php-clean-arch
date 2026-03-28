<?php

namespace App\Livewire\Auth;

use App\Application\UseCases\AuthenticateUserUseCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    protected function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'email'    => 'e-mail',
            'password' => 'senha',
        ];
    }

    public function login(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas. Verifique seu e-mail e senha.',
            ]);
        }

        session()->regenerate();

        $this->redirect(route('dashboard'), navigate: false);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.login');
    }
}
