<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
  /**
   * A basic feature test example.
   */
  use RefreshDatabase;

  public function test_authentification_utilisateur(): void
  {
    $user = User::factory()->create();

    Project::factory(3)->create([
      'created_by' => $user->id,
    ]);
    $response = $this->actingAs($user)
      ->getJson('/api/projects');

    $response->assertStatus(200);
    $response->assertJsonStructure([
      'data' => [
        '*' => [
          'id',
          'name',
          'description',
          'created_by',
          'created_at',
          'updated_at',
        ],
      ],
    ]);
  }
  public function testnon_authentification_des_utilisateurs(): void
  {
    $response = $this->getJson('/api/projects');

    $response->assertStatus(401);
  }

  public function test_un_utilisateur_authentifie_peut_creer_un_projet(): void
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
      ->postJson('/api/projects', [
        'name' => 'Projet Laravel',
        'description' => 'Projet de gestion de tâches',
      ]);

    $response->assertStatus(201);

    $response->assertJsonPath(
      'data.name',
      'Projet Laravel'
    );

    $this->assertDatabaseHas('projects', [
      'name' => 'Projet Laravel',
      'created_by' => $user->id,
    ]);
  }

  public function test_un_projet_sans_nom_est_refuse(): void
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
      ->postJson('/api/projects', [
        'description' => 'Description sans nom',
      ]);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors([
      'name',
    ]);
  }
}
