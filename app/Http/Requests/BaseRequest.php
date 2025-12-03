<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected function rulesUuid(): string
    {
        return 'required|uuid';
    }

    protected function rulesOptionalUuid(): string
    {
        return 'nullable|uuid';
    }

    protected function rulesFutureDate(): string
    {
        return 'nullable|date|after_or_equal:today';
    }

    protected function rulesStatus(): string
    {
        return 'in:todo,in_progress,done';
    }

    protected function rulesUniqueTitle(string $table, string $column = 'title', ?string $ignoreId = null): string
    {
        $rule = "required|string|max:255|unique:$table,$column";
        if ($ignoreId) {
            $rule .= ',' . $ignoreId;
        }
        return $rule;
    }
}
