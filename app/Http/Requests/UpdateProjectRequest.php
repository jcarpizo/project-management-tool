<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProjectRequest extends BaseRequest
{
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
            'title' => $this->rulesUniqueTitle('projects', 'title', $this->route('project')),
            'description' => 'nullable|string',
            'deadline' => $this->rulesFutureDate(),
            'updater_user_id' => ['sometimes', 'uuid', 'exists:users,id'],
        ];
    }
}
