<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;
use App\Services\Task\TaskServiceInterface;
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
        $task = $this->taskService->findTask($id);
        $this->authorize('view', $task); // Policy check
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        return new TaskResource($this->taskService->create($request->validated()));
    }

    public function update(UpdateTaskRequest $request, string $id): TaskResource
    {
        $task = $this->taskService->findTask($id);
        $this->authorize('update', $task); // Policy check
        return new TaskResource($this->taskService->update($id, $request->validated()));
    }

    public function destroy(string $id): Response
    {
        $task = $this->taskService->findTask($id);
        $this->authorize('delete', $task); // Policy check
        $this->taskService->delete($id);
        return response()->noContent();
    }
}
