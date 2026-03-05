<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'transaction_id' => $this['transaction_id'],
            'type' => $this['type'],
            'entry_type' => $this['entry_type'],
            'amount' => number_format((float) $this['amount'], 2, '.', ''),
            'created_at' => $this['created_at'],
        ];
    }
}
