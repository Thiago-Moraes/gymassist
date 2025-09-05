<?php

namespace App\Application\Aluno\Service;

use App\Domain\Aluno\Contract\AlunoRepositoryInterface;

class AlunoService
{
    protected $alunoRepository;

    public function __construct(AlunoRepositoryInterface $alunoRepository)
    {
        $this->alunoRepository = $alunoRepository;
    }

    public function getAllAlunos(): array
    {
        return $this->alunoRepository->all();
    }

    public function getAlunoById(int $id): ?object
    {
        return $this->alunoRepository->find($id);
    }

    public function createAluno(array $data): object
    {
        // Aqui poderíamos adicionar lógicas mais complexas, como disparar eventos.
        return $this->alunoRepository->create($data);
    }

    public function updateAluno(int $id, array $data): bool
    {
        return $this->alunoRepository->update($id, $data);
    }

    public function deleteAluno(int $id): bool
    {
        return $this->alunoRepository->delete($id);
    }
}
