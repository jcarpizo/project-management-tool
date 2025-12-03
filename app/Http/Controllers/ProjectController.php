<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Services\Project\ProjectServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    private ProjectServiceInterface $projectService;

    public function __construct(ProjectServiceInterface $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection($this->projectService->getAll());
    }

    public function show(string $id): ProjectResource
    {
        return new ProjectResource($this->projectService->findProject($id));
    }

    public function store(StoreProjectRequest $request): ProjectResource
    {
        return new ProjectResource($this->projectService->create($request->validated()));
    }

    public function update(UpdateProjectRequest $request, string $id): ProjectResource
    {
        return new ProjectResource($this->projectService->update($id, $request->validated()));
    }

    public function destroy(string $id): Response
    {
        $this->projectService->delete($id);
        return response()->noContent();
    }
}
