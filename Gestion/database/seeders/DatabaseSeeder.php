<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // User::factory(10)->create();

    /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

    //creation des users
    $user = User::factory()->count(10)->create();

    //creation des projets

    $projects = Project::factory(5)
      ->recycle($user)
      ->create();

    //Ajout des users
    foreach ($projects as $project) {
      $project->user()->attach(
        $user->random(rand(2, 5))->pluck('id')
      );
    }
    //Creation des tâches
    $allTasks = collect();
    foreach ($projects as $project) {
      $tasks = Task::factory(rand(3, 6))
        ->create([
          'project_id' => $project->id,
        ]);
      $allTasks = $allTasks->merge($tasks);
    }
    foreach ($allTasks as $task) {
      Comment::factory(rand(1, 4))
        ->create([
          'task_id' => $task->id,
          'user_id' => $user->random()->id,
        ]);
    }
  }
}
