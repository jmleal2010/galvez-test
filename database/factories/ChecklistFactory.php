<?php

namespace Database\Factories;

use App\Models\Checklist;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Checklist>
 */
class ChecklistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::createFromFormat('Y-m-d', '2024-01-01');
        $endDate = Carbon::createFromFormat('Y-m-d', '2024-12-31');

        $randomDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));

        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'date' => $randomDate,
            'tasks' => [
                ['title' => 'Task 1', 'active' => $this->faker->boolean, 'removed' => $this->faker->boolean],
                ['title' => "Task 2", 'active' => $this->faker->boolean, 'removed' => $this->faker->boolean],
                ['title' => "Task 3", 'active' => $this->faker->boolean, 'removed' => $this->faker->boolean]
            ]
        ];
    }
}
