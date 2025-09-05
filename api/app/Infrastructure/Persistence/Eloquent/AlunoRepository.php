<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Aluno\Contract\AlunoRepositoryInterface;
use App\Models\Aluno;

class AlunoRepository implements AlunoRepositoryInterface
{
    public function all(): array
    {
        return Aluno::all()->toArray();
    }

    public function find(int $id): ?object
    {
        return Aluno::find($id);
    }

    public function create(array $data): object
    {
        return Aluno::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $aluno = Aluno::find($id);
        if ($aluno) {
            return $aluno->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $aluno = Aluno::find($id);
        if ($aluno) {
            return $aluno->delete();
        }
        return false;
    }
}
