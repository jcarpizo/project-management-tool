<?php

namespace App\Http\Services\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TaskService implements TaskServiceInterface
{
    public function getAll(): Collection
    {
        return Task::all();
    }

    public function create(array $data): Task
    {
        return DB::transaction(fn() => Task::create($data));
    }

    /**
     * @throws ModelNotFoundException
     */
    public function update(string $id, array $data): ?Task
    {
        $task = $this->findTask($id);
        DB::transaction(fn() => $task->update($data));
        return $task->fresh();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function delete(string $id): bool
    {
        return DB::transaction(fn() => $this->findTask($id)?->delete() ?? false);
    }

    public function findTask(string $id): ?Task
    {
        return Task::find($id);
    }
}
