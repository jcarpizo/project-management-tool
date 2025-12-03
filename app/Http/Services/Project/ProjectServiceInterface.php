<?php

namespace App\Http\Services\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectServiceInterface
{
    public function getAll($user): Collection;
    public function findProject(string $id): ?Project;
    public function create(array $data): Project;
    public function update(string $id, array $data): ?Project;
    public function delete(string $id): bool;
}
