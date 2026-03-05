<?php

namespace App\Http\Resources;

use App\Domain\Entities\TransactionEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var TransactionEntity $entity */
        $entity = $this->resource;

        return $entity->toArray();
    }
}
