<?php

namespace App\Http\Services\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    public function getAll(): Collection;
    public function findTaskOrFail(string $id): ?Task;
    public function create(array $data): Task;
    public function update(string $id, array $data): ?Task;
    public function delete(string $id): bool;
}
