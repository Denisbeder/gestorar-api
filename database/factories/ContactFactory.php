<?php

namespace Database\Factories;

use App\Enums\ContactTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return fake()->randomElement([
            [
                'value' => fake()->email(),
                'type' => ContactTypeEnum::EMAIL->value,
                'description' => fake()->text(50),
            ],
            [
                'value' => fake()->phoneNumber(),
                'type' => ContactTypeEnum::PHONE->value,
            ],
            [
                'value' => '@' . fake()->name(),
                'type' => ContactTypeEnum::TEXT->value,
            ],
        ]);
    }
}
