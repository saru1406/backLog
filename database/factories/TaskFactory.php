<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function() {
                return User::inRandomOrder()->first()->id;
            },
            'project_id' => function() {
                return Project::inRandomOrder()->first()->id;
            },
            'title' => fake()->realText(40),
            'content' => fake()->realText(),
            'status' => fake()->randomElement(['未対応', '処理中', '処理済み', '完了']),
            'priority' => fake()->randomElement(['低', '中', '高']),
            'start_date' => fake()->dateTimeBetween('1day', '1year')->format('Y-m-d H:i'),
            'end_date' => fake()->dateTimeBetween('1day', '1year')->format('Y-m-d H:i'),
        ];
    }
}
