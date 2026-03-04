<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'document' => ['required', 'string', 'unique:users,document', 'cpf_ou_cnpj'],
            'phone' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
