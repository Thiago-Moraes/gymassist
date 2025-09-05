<?php

namespace App\Application\Aparelho\Service;

use App\Domain\Aparelho\Contract\AparelhoRepositoryInterface;

class AparelhoService
{
    protected $aparelhoRepository;

    public function __construct(AparelhoRepositoryInterface $aparelhoRepository)
    {
        $this->aparelhoRepository = $aparelhoRepository;
    }

    public function getAllAparelhos(): array
    {
        return $this->aparelhoRepository->all();
    }

    public function getAparelhoById(int $id): ?object
    {
        return $this->aparelhoRepository->find($id);
    }

    public function createAparelho(array $data): object
    {
        return $this->aparelhoRepository->create($data);
    }

    public function updateAparelho(int $id, array $data): bool
    {
        return $this->aparelhoRepository->update($id, $data);
    }

    public function deleteAparelho(int $id): bool
    {
        return $this->aparelhoRepository->delete($id);
    }
}
