<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_create_project()
    {
        $this->actingAs($this->user);
        $data = [
            'title' => 'New Project',
            'description' => 'Project description',
            'deadline' => now()->addWeek()->toDateString(),
        ];

        $response = $this->postJson('/api/v1/projects', $data);
        $response->assertStatus(201)->assertJsonFragment(['title' => 'New Project']);
        $this->assertDatabaseHas('projects', ['title' => 'New Project']);
    }

    /** @test */
    public function authenticated_user_can_read_project()
    {
        $this->actingAs($this->user);
        $project = Project::factory()->create(['owner_id' => $this->user->id]);
        $response = $this->getJson("/api/v1/projects/{$project->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $project->id]);
    }

    /** @test */
    public function authenticated_user_can_update_project()
    {
        $this->actingAs($this->user);
        $project = Project::factory()->create(['owner_id' => $this->user->id]);
        $updateData = ['title' => 'Updated Title'];
        $response = $this->patchJson("/api/v1/projects/{$project->id}", $updateData);
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated Title']);
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function authenticated_user_can_delete_project()
    {
        $this->actingAs($this->user);
        $project = Project::factory()->create(['owner_id' => $this->user->id]);
        $response = $this->deleteJson("/api/v1/projects/{$project->id}");
        $response->assertStatus(204);
        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }

    /** @test */
    public function authenticated_user_can_create_task()
    {
        $this->actingAs($this->user);
        $project = Project::factory()->create(['owner_id' => $this->user->id]);
        $taskData = [
            'project_id' => $project->id,
            'title' => 'New Task',
            'status' => 'todo',
        ];

        $response = $this->postJson('/api/v1/tasks', $taskData);
        $response->assertStatus(201)->assertJsonFragment(['title' => 'New Task']);
        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    /** @test */
    public function authenticated_user_can_update_task()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create(['project_id' => Project::factory()->create(['owner_id' => $this->user->id])->id]);
        $updateData = ['title' => 'Updated Task', 'status' => 'done'];
        $response = $this->patchJson("/api/v1/tasks/{$task->id}", $updateData);
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated Task', 'status' => 'done']);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Task']);
    }

    /** @test */
    public function authenticated_user_can_delete_task()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create(['project_id' => Project::factory()->create(['owner_id' => $this->user->id])->id]);
        $response = $this->deleteJson("/api/v1/tasks/{$task->id}");
        $response->assertStatus(204);
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function guest_cannot_access_projects_or_tasks()
    {
        $projectData = ['title' => 'Guest Project', 'deadline' => now()->toDateString()];
        $taskData = ['project_id' => 'random-id', 'title' => 'Guest Task', 'status' => 'todo'];

        $this->postJson('/api/v1/projects', $projectData)->assertStatus(401);
        $this->patchJson('/api/v1/projects/random-id', $projectData)->assertStatus(401);
        $this->deleteJson('/api/v1/projects/random-id')->assertStatus(401);

        $this->postJson('/api/v1/tasks', $taskData)->assertStatus(401);
        $this->patchJson('/api/v1/tasks/random-id', $taskData)->assertStatus(401);
        $this->deleteJson('/api/v1/tasks/random-id')->assertStatus(401);
    }
}
