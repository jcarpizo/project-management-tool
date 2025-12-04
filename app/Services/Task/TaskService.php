<?php declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class TaskService implements TaskServiceInterface
{
    public function getAll(): Collection
    {
        return Task::all();
    }

    public function create(array $data): Task
    {
        try {
            return DB::transaction(fn() => Task::create($data));
        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Failed to create task.');
        }
    }

    public function update(string $id, array $data): Task
    {
        $task = $this->findTask($id);

        try {
            DB::transaction(fn() => $task->update($data));
        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Failed to update task.');
        }

        return $task->fresh();
    }

    public function delete(string $id): bool
    {
        $task = $this->findTask($id);

        try {
            return DB::transaction(fn() => $task->delete());
        } catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Failed to delete task.');
        }
    }

    public function findTask(string $id): Task
    {
        return Task::findOrFail($id);
    }
}
