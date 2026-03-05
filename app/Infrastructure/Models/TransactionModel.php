<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TransactionModel extends Model
{
    protected $table = 'transactions';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'transaction_type_id',
        'transaction_status_id',
        'reference_id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ReferenceValueModel::class, 'transaction_type_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ReferenceValueModel::class, 'transaction_status_id');
    }
}
