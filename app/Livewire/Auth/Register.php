<?php

namespace App\Livewire\Auth;

use App\Application\UseCases\RegisterUserUseCase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public string $first_name    = '';
    public string $last_name     = '';
    public string $email         = '';
    public string $document      = '';
    public string $phone         = '';
    public string $birth_date    = '';
    public string $password      = '';
    public string $customer_type = 'common';

    protected function rules(): array
    {
        return [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'document'      => ['required', 'string', 'unique:users,document', 'cpf_ou_cnpj'],
            'phone'         => ['required', 'string'],
            'birth_date'    => ['required', 'date', 'before:today'],
            'password'      => ['required', 'string', 'min:8'],
            'customer_type' => ['required', 'string', 'in:common,merchant'],
        ];
    }

    protected function messages(): array
    {
        return [
            'first_name.required'    => 'O nome é obrigatório.',
            'last_name.required'     => 'O sobrenome é obrigatório.',
            'email.required'         => 'O e-mail é obrigatório.',
            'email.email'            => 'Informe um e-mail válido.',
            'email.unique'           => 'Este e-mail já está cadastrado.',
            'document.required'      => 'O CPF/CNPJ é obrigatório.',
            'document.unique'        => 'Este documento já está cadastrado.',
            'document.cpf_ou_cnpj'   => 'Informe um CPF ou CNPJ válido.',
            'phone.required'         => 'O telefone é obrigatório.',
            'birth_date.required'    => 'A data de nascimento é obrigatória.',
            'birth_date.before'      => 'A data de nascimento deve ser anterior à hoje.',
            'password.required'      => 'A senha é obrigatória.',
            'password.min'           => 'A senha deve ter no mínimo 8 caracteres.',
            'customer_type.required' => 'O tipo de conta é obrigatório.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'first_name'    => 'nome',
            'last_name'     => 'sobrenome',
            'email'         => 'e-mail',
            'document'      => 'CPF/CNPJ',
            'phone'         => 'telefone',
            'birth_date'    => 'data de nascimento',
            'password'      => 'senha',
            'customer_type' => 'tipo de conta',
        ];
    }

    public function register(RegisterUserUseCase $registerUserUseCase): void
    {
        $validated = $this->validate();

        $user = $registerUserUseCase->execute(data: (object) $validated);

        Auth::loginUsingId(id: $user->getId());

        session()->regenerate();

        $this->redirect(route('dashboard'), navigate: false);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.register');
    }
}
