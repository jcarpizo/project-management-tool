<?php declare(strict_types=1);

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class ProjectService implements ProjectServiceInterface
{
    public function getAll($user): Collection
    {
        return Project::with(['tasks.assignee', 'owner:id,name'])
            ->when($user->role !== 'admin', function ($q) use ($user) {
                $q->whereHas('tasks', fn($t) =>
                $t->where('assignee_id', $user->id)
                );
            })
            ->get();
    }

    public function create(array $data): Project
    {
        try {
            return DB::transaction(fn() => Project::create($data));
        } catch (Throwable $e) {
            report($e);
            throw new RuntimeException('Failed to create project.');
        }
    }

    public function update(string $id, array $data): Project
    {
        $project = $this->findProject($id);

        try {
            DB::transaction(fn() => $project->update($data));
        } catch (Throwable $e) {
            report($e);
            throw new RuntimeException('Failed to update project.');
        }

        return $this->findProject($id);
    }

    public function delete(string $id): bool
    {
        $project = $this->findProject($id);

        try {
            return DB::transaction(fn() => $project->delete());
        } catch (Throwable $e) {
            report($e);
            throw new RuntimeException('Failed to delete project.');
        }
    }

    public function findProject(string $id): Project
    {
        return Project::findOrFail($id);
    }
}
