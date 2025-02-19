<?php

namespace App\Models;

use App\Enums\AddressTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'zipcode',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
    ];

    protected function casts(): array
    {
        return [
            'type' => AddressTypeEnum::class,
        ];
    }

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
