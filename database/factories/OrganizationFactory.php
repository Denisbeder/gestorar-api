<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\People;
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
        $name = fake()->company();

        return [
            'name' => $name,
            'legal_name' => $name . ' - ' . fake()->companySuffix(),
            'cnpj' => fake()->randomNumber(9) . fake()->randomNumber(5),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Organization $organization) {
            $organization->addresses()->createMany(Address::factory()->count(2)->make()->toArray());
            $organization->contacts()->createMany(Contact::factory()->count(2)->make()->toArray());
        });
    }
}
