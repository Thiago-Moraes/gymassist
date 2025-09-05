<?php

namespace App\Application\Academia\Service;

use App\Domain\Academia\Contract\AcademiaRepositoryInterface;

class AcademiaService
{
    protected $academiaRepository;

    public function __construct(AcademiaRepositoryInterface $academiaRepository)
    {
        $this->academiaRepository = $academiaRepository;
    }

    public function getAllAcademias(): array
    {
        return $this->academiaRepository->all();
    }

    public function getAcademiaById(int $id): ?object
    {
        return $this->academiaRepository->find($id);
    }

    public function createAcademia(array $data): object
    {
        return $this->academiaRepository->create($data);
    }

    public function updateAcademia(int $id, array $data): bool
    {
        return $this->academiaRepository->update($id, $data);
    }

    public function deleteAcademia(int $id): bool
    {
        return $this->academiaRepository->delete($id);
    }
}
