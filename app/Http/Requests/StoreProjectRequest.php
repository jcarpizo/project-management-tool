<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreProjectRequest extends BaseRequest
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
            'title' => $this->rulesUniqueTitle('projects'),
            'description' => 'nullable|string',
            'deadline' => $this->rulesFutureDate(),
            'owner_id' => $this->rulesUuid() . '|exists:users,id',
        ];
    }
}
