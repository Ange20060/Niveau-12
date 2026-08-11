<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_lister_les_commentaires_d_une_tache(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        Comment::factory(3)->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson("/api/tasks/{$task->id}/comments");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'task_id',
                    'user_id',
                    'description',
                ],
            ],
        ]);
    }

    public function test_un_utilisateur_peut_creer_un_commentaire(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/comments", [
                'description' => 'Très bon travail.',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'description' => 'Très bon travail.',
        ]);
    }

    public function test_un_commentaire_sans_contenu_est_refuse(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $project = Project::factory()->create([
            'created_by' => $user->id,
        ]);

        $task = Task::factory()->create([
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/tasks/{$task->id}/comments", []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'description',
        ]);
    }
}
