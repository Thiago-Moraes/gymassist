<?php

namespace App\Domain\Aluno\Contract;

interface AlunoRepositoryInterface
{
    public function all(): array;

    public function find(int $id): ?object;

    public function create(array $data): object;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
