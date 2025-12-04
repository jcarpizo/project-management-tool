<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreTaskRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'assignee_id' => auth()->id(),
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
            'assignee_id' => 'nullable|exists:users,id',
        ];
    }
}
