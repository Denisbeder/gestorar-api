<?php

namespace App\Models;

use App\Enums\CustomerTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property CustomerTypeEnum $type
 * @property People | Organization $customerable
 */
class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => CustomerTypeEnum::class,
        ];
    }

    public function customerable(): MorphTo
    {
        return $this->morphTo();
    }
}
