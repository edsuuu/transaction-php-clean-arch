<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceValueModel extends Model
{
    protected $table = 'reference_values';

    protected $fillable = [
        'group',
        'code',
        'name',
    ];
}
