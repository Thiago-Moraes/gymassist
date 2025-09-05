<?php

namespace App\Application\FichaTreino\Service;

use App\Domain\Aluno\Contract\AlunoRepositoryInterface;
use App\Domain\Aparelho\Contract\AparelhoRepositoryInterface;
use App\Infrastructure\AI\GeminiClient;
use Carbon\Carbon;
use InvalidArgumentException;

// Importa a classe de exceção

class FichaTreinoService
{
    protected $alunoRepository;
    protected $aparelhoRepository;
    protected $geminiClient;

    public function __construct(
        AlunoRepositoryInterface    $alunoRepository,
        AparelhoRepositoryInterface $aparelhoRepository,
        GeminiClient                $geminiClient
    )
    {
        $this->alunoRepository = $alunoRepository;
        $this->aparelhoRepository = $aparelhoRepository;
        $this->geminiClient = $geminiClient;
    }

    public function getWorkoutSuggestion(int $alunoId, string $frequencia, int $dias): string
    {
        $prompt = $this->generatePrompt($alunoId, $frequencia, $dias);
        return $this->geminiClient->getWorkoutSuggestion($prompt);
    }

    private function generatePrompt(int $alunoId, string $frequencia, int $dias): string
    {
        $aluno = $this->alunoRepository->find($alunoId);

        // Validação para garantir que o aluno foi encontrado
        if (is_null($aluno)) {
            throw new InvalidArgumentException("Aluno com ID {$alunoId} não encontrado.");
        }

        $equipamentosDisponiveis = "Academia completa";
        $idade = Carbon::parse($aluno->birth_date)->age;

        $workoutPlanInstruction = "Crie UMA ficha de treino COMPLETA para o aluno.";
        if ($dias > 1) {
            $workoutPlanInstruction = "Crie DUAS fichas de treino COMPLETAS e DISTINTAS para o aluno.";
        }

        $healtConditions = $aluno->health_conditions ?? 'Nenhuma';
        $preferredExercises = $aluno->preferred_exercises ?? 'Nenhum';
        $avoidExercises = $aluno->avoided_exercises ?? 'Nenhum';
        $previousTraining = $aluno->previous_training ?? 'Nenhum';
        return <<<PROMPT
                    Aja como um personal trainer experiente e crie uma ficha de treino completa para um aluno, considerando as informações abaixo.

                    **Informações do Aluno:**
                    - **Nome:** {$aluno->name}
                    - **Idade:** {$idade}
                    - **Objetivo Principal:** {$aluno->objective}
                    - **Nível de Experiência:** {$aluno->experience_level}
                    - **Frequência de Treino:** {$frequencia}
                    - **Equipamentos Disponíveis:** {$equipamentosDisponiveis}
                    - **Condições de Saúde/Lesões:** {$healtConditions}

                    **Histórico de Treino:**
                    - **Exercícios já executados/preferidos:** {$preferredExercises}
                    - **Exercícios a evitar:** {$avoidExercises}
                    - **Treino anterior:** {$previousTraining}

                    **Instruções para a Ficha de Treino:**
                    {$workoutPlanInstruction}
                    Para CADA ficha de treino, apresente os exercícios em formato json e deve ter as seguintes chaves: 'exercise', 'sets', 'repetitions', 'obs'.

                    Exemplo de formato do retorno:
                    {
                      "record1": [{"exercise": "Aquecimento: Esteira (Caminhada Moderada)", "sets": "1", "repetitions": "5 minutos", "Obs": "Para elevar a temperatura corporal"}],
                      "record2": [{"exercise": "Aquecimento: Esteira (Caminhada Moderada)", "sets": "1", "repetitions": "5 minutos", "Obs": "Para elevar a temperatura corporal"}]
                    }

                    Inclua uma rotina de aquecimento e alongamento ao final de CADA ficha.
                    Garanta que o treino seja seguro e eficiente para o objetivo e nível do aluno.
                    Sugira a progressão de carga ou dificuldade para as próximas semanas.
                    Envie somente a tabela com os exercícios, NÃO ENVIE explicacões.
                    PROMPT;
    }
}
