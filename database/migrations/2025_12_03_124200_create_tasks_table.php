<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->string('title')->unique();
            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->date('due_date')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreignUuid('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('updater_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
