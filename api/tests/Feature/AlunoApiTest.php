<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Filial;
use App\Models\Aluno;

class AlunoApiTest extends TestCase
{
    use RefreshDatabase; // Reseta o banco de dados a cada teste

    /**
     * Testa se o endpoint para listar alunos está funcionando.
     */
    public function test_can_get_all_alunos(): void
    {
        // Cria uma filial para que possamos associar um aluno a ela
        $filial = Filial::factory()->create();
        // Cria 3 alunos de exemplo
        Aluno::factory()->count(3)->create(['filial_id' => $filial->id]);

        $response = $this->getJson('/api/alunos');

        $response->assertStatus(200)
                 ->assertJsonCount(3); // Verifica se os 3 alunos foram retornados
    }

    /**
     * Testa se podemos criar um novo aluno.
     */
    public function test_can_create_an_aluno(): void
    {
        $filial = Filial::factory()->create();

        $alunoData = [
            'filial_id' => $filial->id,
            'name' => 'John Doe',
            'birth_date' => '1990-01-15',
            'objective' => 'Hipertrofia',
            'experience_level' => 'Intermediário',
        ];

        $response = $this->postJson('/api/alunos', $alunoData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'John Doe']);

        $this->assertDatabaseHas('alunos', ['name' => 'John Doe']);
    }
}
