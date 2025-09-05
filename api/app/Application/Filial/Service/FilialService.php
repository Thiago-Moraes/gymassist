<?php

namespace App\Application\Filial\Service;

use App\Domain\Filial\Contract\FilialRepositoryInterface;

class FilialService
{
    protected $filialRepository;

    public function __construct(FilialRepositoryInterface $filialRepository)
    {
        $this->filialRepository = $filialRepository;
    }

    public function getAllFiliais(): array
    {
        return $this->filialRepository->all();
    }

    public function getFilialById(int $id): ?object
    {
        return $this->filialRepository->find($id);
    }

    public function createFilial(array $data): object
    {
        return $this->filialRepository->create($data);
    }

    public function updateFilial(int $id, array $data): bool
    {
        return $this->filialRepository->update($id, $data);
    }

    public function deleteFilial(int $id): bool
    {
        return $this->filialRepository->delete($id);
    }
}
