<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreTaskRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'assigned_to' => auth()->id(),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => $this->rulesUuid() . '|exists:projects,id',
            'title' => $this->rulesUniqueTitle('tasks'),
            'status' => $this->rulesStatus(),
            'due_date' => $this->rulesFutureDate(),
            'assigned_to' => $this->rulesOptionalUuid() . '|exists:users,id',
        ];
    }
}
