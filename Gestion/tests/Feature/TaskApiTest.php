<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_authentifie_peut_lister_les_taches_d_un_projet(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        Task::factory(3)->create([
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson("/api/projects/{$project->id}/tasks");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'project_id',
                    'title',
                    'description',
                    'status',
                ],
            ],
        ]);
    }

    public function test_un_utilisateur_authentifie_peut_creer_une_tache(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/projects/{$project->id}/tasks", [
                'title' => 'Créer le contrôleur',
                'description' => 'Développer TaskController',
                'status' => 'todo',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'title' => 'Créer le contrôleur',
            'status' => 'todo',
        ]);
    }

    public function test_une_tache_sans_titre_est_refusee(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/projects/{$project->id}/tasks", [
                'description' => 'Une tâche sans titre',
                'status' => 'todo',
            ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'title',
        ]);
    }

    public function test_une_tache_peut_etre_modifiee(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'status' => 'todo',
        ]);

        $response = $this->actingAs($user)
            ->patchJson("/api/tasks/{$task->id}", [
                'status' => 'done',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'done',
        ]);
    }

    public function test_une_tache_peut_etre_supprimee(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/tasks/'.$task->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
