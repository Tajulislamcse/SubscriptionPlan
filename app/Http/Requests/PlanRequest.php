<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $planId = $this->route('plan');
        return [
            'name' => [
                'required', 'string', Rule::unique('plans', 'name')->ignore($planId),
            ],
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'data_limit' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ];
    }
}
