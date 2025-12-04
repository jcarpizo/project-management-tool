<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreProjectRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'owner_id' => auth()->id(),
        ]);
    }

    /**
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
