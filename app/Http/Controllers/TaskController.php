<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Services\Task\TaskService;
use App\Http\Services\Task\TaskServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private TaskServiceInterface $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection($this->taskService->getAll());
    }

    public function show(string $id): TaskResource
    {
        return new TaskResource($this->taskService->findTask($id));
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        return new TaskResource($this->taskService->create($request->validated()));
    }

    public function update(UpdateTaskRequest $request, string $id): TaskResource
    {
        return new TaskResource($this->taskService->update($id, $request->validated()));
    }

    public function destroy(string $id): Response
    {
        $this->taskService->delete($id);
        return response()->noContent();
    }
}
