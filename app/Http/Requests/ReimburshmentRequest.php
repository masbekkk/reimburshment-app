<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReimburshmentRequest extends FormRequest
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
        return [
            'date_of_submission' => 'required|date',
            'reimburshment_name' => 'required|string|max:255',
            'description' => 'required|string',
            'support_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'status' => 'nullable|in:on_progress,accept,reject',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
