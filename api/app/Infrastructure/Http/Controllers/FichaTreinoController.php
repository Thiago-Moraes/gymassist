<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\FichaTreino\Service\FichaTreinoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FichaTreinoController extends Controller
{
    private $fichaTreinoService;

    public function __construct(FichaTreinoService $fichaTreinoService)
    {
        $this->fichaTreinoService = $fichaTreinoService;
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
