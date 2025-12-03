<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => $this->rulesUuid() . '|exists:projects,id',
            'title' => $this->rulesTitle(),
            'status' => $this->rulesStatus(),
            'due_date' => $this->rulesFutureDate(),
            'assigned_to' => $this->rulesOptionalUuid() . '|exists:users,id',
        ];
    }
}
