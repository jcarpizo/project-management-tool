<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private ProjectServiceInterface $projectService;

    public function __construct(ProjectServiceInterface $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(): AnonymousResourceCollection
    {
        $projects = $this->projectService->getAll(Auth::user());
        return ProjectResource::collection($projects);
    }

    public function show(string $id): ProjectResource
    {
        $project = $this->projectService->findProject($id);
        $this->authorize('view', $project); // Policy check
        return new ProjectResource($project);
    }

    public function store(StoreProjectRequest $request): ProjectResource
    {
        $this->authorize('create', Project::class); // Policy check
        return new ProjectResource($this->projectService->create($request->validated()));
    }

    public function update(UpdateProjectRequest $request, string $id): ProjectResource
    {
        $project = $this->projectService->findProject($id);
        $this->authorize('update', $project); // Policy check
        return new ProjectResource($this->projectService->update($id, $request->validated()));
    }

    public function destroy(string $id): Response
    {
        $project = $this->projectService->findProject($id);
        $this->authorize('delete', $project); // Policy check
        $this->projectService->delete($id);
        return response()->noContent();
    }
}
