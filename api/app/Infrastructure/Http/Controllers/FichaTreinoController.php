<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\FichaTreino\Service\FichaTreinoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\FichaTreino;
use App\Models\ExercicioFicha;

class FichaTreinoController extends Controller
{
    private $fichaTreinoService;

    public function __construct(FichaTreinoService $fichaTreinoService)
    {
        $this->fichaTreinoService = $fichaTreinoService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|integer|exists:alunos,id',
            'fichas' => 'required|array',
            'fichas.*.name' => 'required|string',
            'fichas.*.exercicios' => 'required|array',
            'fichas.*.exercicios.*.exercise' => 'required|string',
            'fichas.*.exercicios.*.sets' => 'required|string',
            'fichas.*.exercicios.*.repetitions' => 'required|string',
            'fichas.*.exercicios.*.Obs' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->input('fichas') as $fichaData) {
                $fichaTreino = FichaTreino::create([
                    'aluno_id' => $request->input('aluno_id'),
                    'name' => $fichaData['name'],
                ]);

                foreach ($fichaData['exercicios'] as $exercicioData) {
                    ExercicioFicha::create([
                        'ficha_treino_id' => $fichaTreino->id,
                        'exercise' => $exercicioData['exercise'],
                        'sets' => $exercicioData['sets'],
                        'repetitions' => $exercicioData['repetitions'],
                        'observations' => $exercicioData['Obs'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Fichas de treino salvas com sucesso!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao salvar fichas de treino', 'error' => $e->getMessage()], 500);
        }
    }

    public function suggest(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'aluno_id' => 'required|integer|exists:alunos,id',
            'frequencia' => 'required|string',
            'dias' => 'required|integer|min:1|max:7',
        ]);

        $suggestion = $this->fichaTreinoService->getWorkoutSuggestion(
            $validated['aluno_id'],
            $validated['frequencia'],
            $validated['dias']
        );

        $suggestion = preg_replace([ '/"""|```json|```/' ], '', $suggestion);
        $suggestion = trim($suggestion);
        $suggestion = json_decode($suggestion, true);

        return response()->json(['suggestion' => $suggestion]);
    }
}
