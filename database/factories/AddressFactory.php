<?php

namespace Database\Factories;

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
            'type' => fake()->randomElement(),
            'zipcode' => fake()->name(),
            'street' => fake()->name(),
            'number' => fake()->name(),
            'neighborhood' => fake()->name(),
            'city' => fake()->name(),
            'state' => fake()->name(),
            'complement' => fake()->name(),
        ];
    }
}
