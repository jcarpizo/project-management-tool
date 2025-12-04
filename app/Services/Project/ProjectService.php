<?php declare(strict_types=1);

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProjectService implements ProjectServiceInterface
{
    public function getAll($user): Collection
    {
        return Project::with(['tasks.assignee', 'owner:id,name'])
            ->when($user->role !== 'admin', fn($q) =>
            $q->where('owner_id', $user->id)
            )
            ->get();
    }

    public function create(array $data): Project
    {
        return DB::transaction(fn() => Project::create($data));
    }

    /**
     * @throws ModelNotFoundException
     */
    public function update(string $id, array $data): ?Project
    {
        return DB::transaction(fn() => $this->findProject($id)?->update($data) ? $this->findProject($id) : null);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function delete(string $id): bool
    {
        return DB::transaction(fn() => $this->findProject($id)?->delete() ?? false);
    }

    public function findProject(string $id): ?Project
    {
        return Project::find($id);
    }
}
