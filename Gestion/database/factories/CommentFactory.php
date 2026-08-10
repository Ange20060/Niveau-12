<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Termwind\Components\Paragraph;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
  use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id'=>Task::factory(),
            'user_id'=>User::factory(),
            'description'=>fake()->paragraph(),
        ];
    }
}
