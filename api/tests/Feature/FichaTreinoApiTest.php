<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Aluno;
use App\Models\FichaTreino;
use App\Models\ExercicioFicha;
use App\Models\Academia;
use App\Models\Filial;

class FichaTreinoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a API consegue salvar fichas de treino com sucesso.
     *
     * @return void
     */
    public function test_can_save_workout_sheets()
    {
        // Criar uma academia e filial para satisfazer as chaves estrangeiras
        $academia = Academia::factory()->create();
        $filial = Filial::factory()->create(['academia_id' => $academia->id]);

        // Criar um aluno para vincular a ficha de treino
        $aluno = Aluno::factory()->create(['filial_id' => $filial->id]);

        $data = [
            'aluno_id' => $aluno->id,
            'fichas' => [
                [
                    'name' => 'Ficha de Treino 1',
                    'exercicios' => [
                        [
                            'exercise' => 'Supino Reto',
                            'sets' => '3',
                            'repetitions' => '8-12',
                            'Obs' => 'Carga progressiva',
                        ],
                        [
                            'exercise' => 'Crucifixo',
                            'sets' => '3',
                            'repetitions' => '10-15',
                            'Obs' => 'Movimento controlado',
                        ],
                    ],
                ],
                [
                    'name' => 'Ficha de Treino 2',
                    'exercicios' => [
                        [
                            'exercise' => 'Agachamento',
                            'sets' => '4',
                            'repetitions' => '10-15',
                            'Obs' => 'Descer até 90 graus',
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->postJson('/api/fichas-treino', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Fichas de treino salvas com sucesso!'
                 ]);

        // Verificar se as fichas de treino foram salvas no banco de dados
        $this->assertDatabaseCount('fichas_treino', 2);
        $this->assertDatabaseHas('fichas_treino', [
            'aluno_id' => $aluno->id,
            'name' => 'Ficha de Treino 1',
        ]);
        $this->assertDatabaseHas('fichas_treino', [
            'aluno_id' => $aluno->id,
            'name' => 'Ficha de Treino 2',
        ]);

        // Verificar se os exercícios foram salvos no banco de dados
        $this->assertDatabaseCount('exercicios_ficha', 3); // 2 da Ficha 1 + 1 da Ficha 2

        $ficha1 = FichaTreino::where('name', 'Ficha de Treino 1')->first();
        $ficha2 = FichaTreino::where('name', 'Ficha de Treino 2')->first();

        $this->assertDatabaseHas('exercicios_ficha', [
            'ficha_treino_id' => $ficha1->id,
            'exercise' => 'Supino Reto',
            'sets' => '3',
            'repetitions' => '8-12',
            'observations' => 'Carga progressiva',
        ]);
        $this->assertDatabaseHas('exercicios_ficha', [
            'ficha_treino_id' => $ficha2->id,
            'exercise' => 'Agachamento',
            'sets' => '4',
            'repetitions' => '10-15',
            'observations' => 'Descer até 90 graus',
        ]);
    }

    /**
     * Testa se a API retorna erro com dados inválidos.
     *
     * @return void
     */
    public function test_cannot_save_workout_sheets_with_invalid_data()
    {
        $response = $this->postJson('/api/fichas-treino', [
            'aluno_id' => 999, // Aluno inexistente
            'fichas' => [
                [
                    'name' => 'Ficha Inválida',
                    'exercicios' => [
                        [
                            'exercise' => '', // Exercício vazio
                            'sets' => '3',
                            'repetitions' => '8-12',
                            'Obs' => 'Observação',
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertStatus(422) // 422 Unprocessable Entity para erros de validação
                 ->assertJsonValidationErrors(['aluno_id', 'fichas.0.exercicios.0.exercise']);

        $this->assertDatabaseCount('fichas_treino', 0);
        $this->assertDatabaseCount('exercicios_ficha', 0);
    }
}
