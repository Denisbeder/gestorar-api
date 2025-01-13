<?php

namespace Database\Factories;

use App\Enums\WorkOrderStatusEnum;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkOrder>
 */
class WorkOrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusCases = array_map(fn ($case) => $case->value, WorkOrderStatusEnum::cases());
        $status = fake()->randomElement($statusCases);
        $date = now();
        $randomSentNumber = fake()->numberBetween(2, 5);
        $randomAddNumber = $randomSentNumber + fake()->numberBetween(2, 5);

        $data = [
            'customer_id' => Customer::factory(),
            'code' => fake()->randomNumber(),
            'status' => $status,
            'date' => $date,
            'validity' => $date->copy()->addMonth(),
            'extra' => 0,
            'discount' => 0,
            'description' => fake()->sentence(),
            'extra_description' => null,
            'discount_description' => null,
            'services' => [],
            'sent_at' => $date->copy()->addMinutes($randomSentNumber),
            'read_at' => fake()->randomElement([null, $date->copy()->addMinutes($randomAddNumber)]),
            'approved_at' => null,
            'declined_at' => null,
            'cancelled_at' => null,
            'completed_at' => null,
        ];

        $extraData = [
            'extra' => fake()->randomFloat(2, 0, 10),
            'extra_description' => fake()->sentence(),
        ];

        $discountData = [
            'discount' => fake()->randomFloat(2, 0, 10),
            'discount_description' => fake()->sentence(),
        ];

        $extraDiscountData = fake()->randomElement([[], $extraData, $discountData, [...$extraData, ...$discountData]]);

        $statusData = match ($status) {
            WorkOrderStatusEnum::CANCELLED->value => [
                'cancelled_at' => $date->copy()->addDays($randomAddNumber),
            ],
            WorkOrderStatusEnum::COMPLETED->value => [
                'read_at' => $date->copy()->addMinutes($randomAddNumber),
                'approved_at' => $date->copy()->addDays($randomAddNumber),
                'completed_at' => $date->copy()->addDays($randomAddNumber + fake()->numberBetween(0, 2)),
            ],
            WorkOrderStatusEnum::DECLINED->value => [
                'read_at' => $date->copy()->addMinutes($randomAddNumber),
                'declined_at' => $date->copy()->addDays($randomAddNumber),
            ],
            WorkOrderStatusEnum::APPROVED->value => [
                'read_at' => $date->copy()->addMinutes($randomAddNumber),
                'approved_at' => $date->copy()->addDays($randomAddNumber),
                'cancelled_at' => fake()->randomElement([null, $date->copy()->addDays($randomAddNumber + 1), $date->copy()->addMinutes($randomAddNumber + 1)]),
            ],
            default => [],
        };

        return array_merge($data, $statusData, $extraDiscountData);
    }
}
