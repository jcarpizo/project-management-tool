<?php

namespace App\Http\Services\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProjectService implements ProjectServiceInterface
{
    public function getAll(): Collection
    {
        return Project::with(['tasks' => function ($query) {$query->whereNull('deleted_at');
        }, 'tasks.assignee'])->get();
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
