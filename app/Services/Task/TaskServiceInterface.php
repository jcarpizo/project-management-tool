<?php declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    public function getAll(): Collection;
    public function findTask(string $id): ?Task;
    public function create(array $data): Task;
    public function update(string $id, array $data): ?Task;
    public function delete(string $id): bool;
}
