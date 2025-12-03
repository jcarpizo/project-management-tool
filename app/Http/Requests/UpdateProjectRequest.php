<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProjectRequest extends BaseRequest
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
            'title' => $this->rulesUniqueTitle('projects', 'title', $this->route('project')),
            'description' => 'nullable|string',
            'deadline' => $this->rulesFutureDate(),
            'updater_user_id' => ['sometimes', 'uuid', 'exists:users,id'],
        ];
    }
}
