<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Filial\Contract\FilialRepositoryInterface;
use App\Models\Filial;

class FilialRepository implements FilialRepositoryInterface
{
    public function all(): array
    {
        return Filial::all()->toArray();
    }

    public function find(int $id): ?object
    {
        return Filial::find($id);
    }

    public function create(array $data): object
    {
        return Filial::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $filial = Filial::find($id);
        if ($filial) {
            return $filial->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $filial = Filial::find($id);
        if ($filial) {
            return $filial->delete();
        }
        return false;
    }
}
