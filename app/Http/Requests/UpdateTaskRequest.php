<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateTaskRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'updater_user_id' => auth()->id(),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => 'sometimes|' . $this->rulesUuid() . '|exists:projects,id',
            'title' => $this->rulesUniqueTitle('tasks', 'title', $this->route('task')),
            'status' => 'sometimes|' . $this->rulesStatus(),
            'due_date' => $this->rulesFutureDate(),
            'assigned_to' => $this->rulesOptionalUuid() . '|exists:users,id',
            'updater_user_id' => ['sometimes', 'uuid', 'exists:users,id'],
        ];
    }
}
