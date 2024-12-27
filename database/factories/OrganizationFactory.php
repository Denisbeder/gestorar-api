<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company()->unique();

        return [
            'name' => $name,
            'legal_name' => $name . ' - ' . fake()->companySuffix(),
            'cnpj' => fake()->randomNumber(14),
        ];
    }
}
