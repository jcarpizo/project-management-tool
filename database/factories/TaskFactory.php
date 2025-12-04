<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'done']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        ];
    }
}
