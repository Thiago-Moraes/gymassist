<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Aparelho\Contract\AparelhoRepositoryInterface;
use App\Models\Aparelho;

class AparelhoRepository implements AparelhoRepositoryInterface
{
    public function all(): array
    {
        return Aparelho::all()->toArray();
    }

    public function find(int $id): ?object
    {
        return Aparelho::find($id);
    }

    public function create(array $data): object
    {
        return Aparelho::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $aparelho = Aparelho::find($id);
        if ($aparelho) {
            return $aparelho->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $aparelho = Aparelho::find($id);
        if ($aparelho) {
            return $aparelho->delete();
        }
        return false;
    }
}
