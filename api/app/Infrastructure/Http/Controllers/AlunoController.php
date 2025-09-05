<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Aluno\Service\AlunoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AlunoController extends Controller
{
    private $alunoService;

    public function __construct(AlunoService $alunoService)
    {
        $this->alunoService = $alunoService;
    }

    public function index(): JsonResponse
    {
        $alunos = $this->alunoService->getAllAlunos();
        return response()->json($alunos);
    }

    public function store(Request $request): JsonResponse
    {
        $aluno = $this->alunoService->createAluno($request->all());
        return response()->json($aluno, 201);
    }

    public function show(int $id): JsonResponse
    {
        $aluno = $this->alunoService->getAlunoById($id);
        if (!$aluno) {
            return response()->json(['message' => 'Aluno not found'], 404);
        }
        return response()->json($aluno);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $success = $this->alunoService->updateAluno($id, $request->all());
        if (!$success) {
            return response()->json(['message' => 'Aluno not found or could not be updated'], 404);
        }
        return response()->json(['message' => 'Aluno updated successfully']);
    }

    public function destroy(int $id): JsonResponse
    {
        $success = $this->alunoService->deleteAluno($id);
        if (!$success) {
            return response()->json(['message' => 'Aluno not found'], 404);
        }
        return response()->json(null, 204);
    }
}
