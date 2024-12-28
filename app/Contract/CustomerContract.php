<?php

namespace App\Contract;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface CustomerContract
{
    public function customer(): MorphOne;
}
