<?php declare(strict_types=1);

namespace App\Services\Project;

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
