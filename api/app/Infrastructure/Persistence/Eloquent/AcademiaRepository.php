<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Academia\Contract\AcademiaRepositoryInterface;
use App\Models\Academia;

class AcademiaRepository implements AcademiaRepositoryInterface
{
    public function all(): array
    {
        return Academia::all()->toArray();
    }

    public function find(int $id): ?object
    {
        return Academia::find($id);
    }

    public function create(array $data): object
    {
        return Academia::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $academia = Academia::find($id);
        if ($academia) {
            return $academia->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $academia = Academia::find($id);
        if ($academia) {
            return $academia->delete();
        }
        return false;
    }
}
