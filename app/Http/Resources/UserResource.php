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
            'full_name' => $this->getFullName(),
            'email' => $this->getEmail(),
            'customer_type' => $this->getCustomerType(),
        ];
    }
}
