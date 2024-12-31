<?php

namespace Database\Factories;

use App\Enums\AddressTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement([AddressTypeEnum::HOME->value, AddressTypeEnum::COMMERCIAL->value, AddressTypeEnum::BILLING->value]),
            'zipcode' => fake()->randomNumber(8),
            'street' => fake()->streetName(),
            'number' => fake()->randomNumber(),
            'neighborhood' => fake()->name(),
            'city' => fake()->city(),
            'state' => fake()->citySuffix(),
            'complement' => fake()->sentence(),
        ];
    }
}
