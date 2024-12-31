<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Contact;
use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\People>
 */
class PeopleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'cpf' => fake()->randomNumber(9) . fake()->randomNumber(2),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (People $people) {
            $people->addresses()
                ->createMany(
                    Address::factory()
                        ->count(fake()->numberBetween(1, 3))
                        ->make()
                        ->toArray()
                );

            $people->contacts()
                ->createMany(
                    Contact::factory()
                        ->count(fake()->numberBetween(1, 5))
                        ->make()
                        ->toArray()
                );
        });
    }
}
