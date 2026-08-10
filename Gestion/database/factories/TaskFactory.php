<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
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
            'project_id'=>Project::factory(),
            'title'=> fake()->sentence(3),
            'description'=>fake()->paragraph(),
            'status'=>fake()->randomElement([
              'todo',
              'in_progress',
              'done',
            ])
        ];
    }
}
