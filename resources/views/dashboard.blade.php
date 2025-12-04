<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="projectTaskCrud()" x-init="init()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Error Messages -->
            <template x-if="errors.length">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Errors:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        <template x-for="error in errors" :key="error">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    <span @click="errors = []" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">&times;</span>
                </div>
            </template>

            <!-- Project Form -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4" x-text="editProjectMode ? 'Edit Project' : 'New Project'"></h3>
                <form @submit.prevent="saveProject">
                    <div class="mb-4">
                        <label class="block text-gray-700">Title</label>
                        <input type="text" x-model="projectForm.title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Description</label>
                        <textarea x-model="projectForm.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Deadline</label>
                        <input type="date" x-model="projectForm.deadline" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-blue-700" x-text="editProjectMode ? 'Update Project' : 'Create Project'"></button>
                        <button type="button" @click="resetProjectForm" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Projects List -->
            <template x-for="project in projects" :key="project.id">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <!-- Project Header -->
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-semibold text-lg" x-text="project.title"></h3>
                            <p class="text-gray-500 text-sm"><strong x-text="project.description"></strong></p>
                            <p class="text-gray-400 text-xs">Deadline: <strong x-text="project.deadline ?? 'N/A'"></strong></p>
                            <p class="text-gray-400 text-xs">Owner: <strong x-text="project.owner?.name ?? 'Unknown'"></strong></p>
                            <p class="text-gray-400 text-xs">Progress: <strong x-text="project.progress + '%'"></strong></p>
                        </div>
                        <div class="space-x-2">
                            <button @click="project.showTasks = !project.showTasks" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-green-700">Manage Tasks</button>
                            <button @click="editProject(project)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-yellow-600">Edit</button>
                            <button @click="deleteProject(project.id)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </div>
                    </div>

                    <!-- Task Section -->
                    <div x-show="project.showTasks" class="mt-4 border-t pt-4" x-transition>
                        <!-- Task Form -->
                        <div class="mb-4">
                            <h4 class="font-medium mb-2" x-text="project.editTaskMode ? 'Edit Task' : 'New Task'"></h4>
                            <form @submit.prevent="saveTask(project)">
                                <div class="mb-2">
                                    <label class="block text-gray-700">Title</label>
                                    <input type="text" x-model="project.taskForm.title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-gray-700">Status</label>
                                    <select x-model="project.taskForm.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="todo">Todo</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="done">Done</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-gray-700">Due Date</label>
                                    <input type="date" x-model="project.taskForm.due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-green-700" x-text="project.editTaskMode ? 'Update Task' : 'Create Task'"></button>
                                    <button type="button" @click="resetTaskForm(project)" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</button>
                                </div>
                            </form>
                        </div>

                        <!-- Task List -->
                        <ul class="space-y-2">
                            <template x-for="task in project.tasks" :key="task.id">
                                <li class="flex justify-between items-center border-b py-2">
                                    <div>
                                        <p class="font-medium" x-text="task.title"></p>
                                        <p class="text-gray-500 text-sm">Status: <span x-text="task.status"></span></p>
                                        <p class="text-gray-400 text-xs">Due: <span x-text="task.due_date ?? 'N/A'"></span></p>
                                        <p class="text-gray-400 text-xs">Assigned: <span x-text="task.assignee_id_user?.name ?? 'N/A'"></span></p>
                                    </div>
                                    <div class="space-x-2">
                                        <button @click="editTask(task, project)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-yellow-600">Edit</button>
                                        <button @click="deleteTask(task.id)" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Pass token from Blade -->
    <script>
        const API_TOKEN = "{{ auth()->user()->currentAccessToken()?->plainTextToken ?? auth()->user()->createToken('api-token')->plainTextToken }}";
    </script>

    <script>
        function projectTaskCrud() {
            return {
                projects: [],
                editProjectMode: false,
                projectForm: { id: null, title: '', description: '', deadline: '' },
                errors: [], // <-- array to hold all error messages

                init() {
                    this.fetchProjects();
                },

                getHeaders() {
                    return {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${API_TOKEN}`
                    };
                },

                async fetchProjects() {
                    try {
                        const res = await fetch('/api/v1/projects', { headers: this.getHeaders() });
                        if (!res.ok) throw await res.json();
                        const data = await res.json();
                        this.projects = (data.data || []).map(p => ({
                            ...p,
                            tasks: Array.isArray(p.tasks) ? p.tasks : [],
                            taskForm: { id: null, title: '', status: 'todo', due_date: '', assignee_id: null },
                            editTaskMode: false,
                            showTasks: false,
                            progress: p.tasks && p.tasks.length > 0
                                ? Math.round((p.tasks.filter(t => t.status === 'done').length / p.tasks.length) * 100)
                                : 0
                        }));
                        this.errors = [];
                    } catch (err) {
                        this.errors = Array.isArray(err.errors) ? Object.values(err.errors).flat() : [err.message || 'Unknown error'];
                    }
                },

                /* Project CRUD */
                async saveProject() {
                    try {
                        const url = this.editProjectMode ? `/api/v1/projects/${this.projectForm.id}` : '/api/v1/projects';
                        const method = this.editProjectMode ? 'PATCH' : 'POST';
                        const res = await fetch(url, {
                            method,
                            headers: this.getHeaders(),
                            body: JSON.stringify(this.projectForm)
                        });
                        const data = await res.json();
                        if (!res.ok) throw data;

                        this.resetProjectForm();
                        this.fetchProjects();
                        this.errors = [];
                    } catch (err) {
                        this.errors = Array.isArray(err.errors) ? Object.values(err.errors).flat() : [err.message || 'Unknown error'];
                    }
                },

                editProject(project) {
                    this.editProjectMode = true;
                    this.projectForm = JSON.parse(JSON.stringify(project));
                },

                async deleteProject(id) {
                    if (!confirm('Are you sure you want to delete this project?')) return;
                    try {
                        const res = await fetch(`/api/v1/projects/${id}`, { method: 'DELETE', headers: this.getHeaders() });
                        if (!res.ok) throw await res.json();
                        this.fetchProjects();
                        this.errors = [];
                    } catch (err) {
                        this.errors = Array.isArray(err.errors) ? Object.values(err.errors).flat() : [err.message || 'Unknown error'];
                    }
                },

                resetProjectForm() {
                    this.editProjectMode = false;
                    this.projectForm = { id: null, title: '', description: '', deadline: '' };
                },

                /* Task CRUD */
                async saveTask(project) {
                    try {
                        const taskForm = project.taskForm;
                        taskForm.project_id = project.id;
                        const url = taskForm.id ? `/api/v1/tasks/${taskForm.id}` : '/api/v1/tasks';
                        const method = taskForm.id ? 'PUT' : 'POST';
                        const res = await fetch(url, {
                            method,
                            headers: this.getHeaders(),
                            body: JSON.stringify(taskForm)
                        });
                        const data = await res.json();
                        if (!res.ok) throw data;

                        this.resetTaskForm(project);
                        this.fetchProjects();
                        this.errors = [];
                    } catch (err) {
                        this.errors = Array.isArray(err.errors) ? Object.values(err.errors).flat() : [err.message || 'Unknown error'];
                    }
                },

                editTask(task, project) {
                    project.editTaskMode = true;
                    project.taskForm = {
                        id: task.id,
                        title: task.title ?? '',
                        status: task.status ?? 'todo',
                        due_date: task.due_date ?? '',
                        assignee_id: task.assignee_id ?? null
                    };
                    project.showTasks = true;
                },

                async deleteTask(task_id) {
                    if (!confirm('Are you sure you want to delete this task?')) return;
                    try {
                        const res = await fetch(`/api/v1/tasks/${task_id}`, { method: 'DELETE', headers: this.getHeaders() });
                        if (!res.ok) throw await res.json();
                        this.fetchProjects();
                        this.errors = [];
                    } catch (err) {
                        this.errors = Array.isArray(err.errors) ? Object.values(err.errors).flat() : [err.message || 'Unknown error'];
                    }
                },

                resetTaskForm(project) {
                    project.editTaskMode = false;
                    project.taskForm = { id: null, title: '', status: 'todo', due_date: '', assignee_id: null };
                }
            }
        }
    </script>
</x-app-layout>
