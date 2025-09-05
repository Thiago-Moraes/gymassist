<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Filial\Service\FilialService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FilialController extends Controller
{
    private $filialService;

    public function __construct(FilialService $filialService)
    {
        $this->filialService = $filialService;
    }

    public function index(): JsonResponse
    {
        $filiais = $this->filialService->getAllFiliais();
        return response()->json($filiais);
    }

    public function store(Request $request): JsonResponse
    {
        $filial = $this->filialService->createFilial($request->all());
        return response()->json($filial, 201);
    }

    public function show(int $id): JsonResponse
    {
        $filial = $this->filialService->getFilialById($id);
        if (!$filial) {
            return response()->json(['message' => 'Filial not found'], 404);
        }
        return response()->json($filial);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $success = $this->filialService->updateFilial($id, $request->all());
        if (!$success) {
            return response()->json(['message' => 'Filial not found or could not be updated'], 404);
        }
        return response()->json(['message' => 'Filial updated successfully']);
    }

    public function destroy(int $id): JsonResponse
    {
        $success = $this->filialService->deleteFilial($id);
        if (!$success) {
            return response()->json(['message' => 'Filial not found'], 404);
        }
        return response()->json(null, 204);
    }
}
