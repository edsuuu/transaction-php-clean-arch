<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'full_name' => $this->getFullName(),
            'email' => $this->getEmail(),
            'document' => $this->getDocument(),
            'phone' => $this->getPhone(),
            'birth_date' => $this->getBirthDate(),
            'customer_type' => $this->getCustomerType(),
        ];
    }
}
