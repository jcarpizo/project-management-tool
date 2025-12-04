<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'owner_id' => User::factory(),
        ];
    }
}
