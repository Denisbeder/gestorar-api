<?php

namespace App\Models;

use App\Enums\ContactTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'type' => ContactTypeEnum::class,
        ];
    }

    public function contactable(): MorphTo
    {
        return $this->morphTo();
    }
}
