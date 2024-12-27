<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
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

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
