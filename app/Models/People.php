<?php

namespace App\Models;

use App\Contract\CustomerContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class People extends Model implements CustomerContract
{
    /** @use HasFactory<\Database\Factories\PeopleFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'cpf',
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function customer(): MorphOne
    {
        return $this->morphOne(Customer::class, 'customerable');
    }
}
