<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Aparelho\Service\AparelhoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AparelhoController extends Controller
{
    private $aparelhoService;

    public function __construct(AparelhoService $aparelhoService)
    {
        $this->aparelhoService = $aparelhoService;
    }

    public function index(): JsonResponse
    {
        $aparelhos = $this->aparelhoService->getAllAparelhos();
        return response()->json($aparelhos);
    }

    public function store(Request $request): JsonResponse
    {
        $aparelho = $this->aparelhoService->createAparelho($request->all());
        return response()->json($aparelho, 201);
    }

    public function show(int $id): JsonResponse
    {
        $aparelho = $this->aparelhoService->getAparelhoById($id);
        if (!$aparelho) {
            return response()->json(['message' => 'Aparelho not found'], 404);
        }
        return response()->json($aparelho);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $success = $this->aparelhoService->updateAparelho($id, $request->all());
        if (!$success) {
            return response()->json(['message' => 'Aparelho not found or could not be updated'], 404);
        }
        return response()->json(['message' => 'Aparelho updated successfully']);
    }

    public function destroy(int $id): JsonResponse
    {
        $success = $this->aparelhoService->deleteAparelho($id);
        if (!$success) {
            return response()->json(['message' => 'Aparelho not found'], 404);
        }
        return response()->json(null, 204);
    }
}
