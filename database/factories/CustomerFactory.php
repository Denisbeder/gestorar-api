<?php

namespace Database\Factories;

use App\Enums\CustomerTypeEnum;
use App\Models\Organization;
use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return fake()->randomElement([
            [
                'customerable_id' => People::factory(),
                'customerable_type' => People::class,
                'type' => CustomerTypeEnum::CPF->value,
            ],
            [
                'customerable_id' => Organization::factory(),
                'customerable_type' => Organization::class,
                'type' => CustomerTypeEnum::CNPJ->value,
            ],
        ]);
    }
}
