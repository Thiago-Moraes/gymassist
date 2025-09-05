<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Academia\Service\AcademiaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AcademiaController extends Controller
{
    private $academiaService;

    public function __construct(AcademiaService $academiaService)
    {
        $this->academiaService = $academiaService;
    }

    public function index(): JsonResponse
    {
        $academias = $this->academiaService->getAllAcademias();
        return response()->json($academias);
    }

    public function store(Request $request): JsonResponse
    {
        $academia = $this->academiaService->createAcademia($request->all());
        return response()->json($academia, 201);
    }

    public function show(int $id): JsonResponse
    {
        $academia = $this->academiaService->getAcademiaById($id);
        if (!$academia) {
            return response()->json(['message' => 'Academia not found'], 404);
        }
        return response()->json($academia);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $success = $this->academiaService->updateAcademia($id, $request->all());
        if (!$success) {
            return response()->json(['message' => 'Academia not found or could not be updated'], 404);
        }
        return response()->json(['message' => 'Academia updated successfully']);
    }

    public function destroy(int $id): JsonResponse
    {
        $success = $this->academiaService->deleteAcademia($id);
        if (!$success) {
            return response()->json(['message' => 'Academia not found'], 404);
        }
        return response()->json(null, 204);
    }
}
