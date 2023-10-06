<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchAPITaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'string'],
            'priority' => ['nullable', 'string'],
        ];
    }

    public function getUserId()
    {
        return $this->input('user_id');
    }

    public function getStatus()
    {
        return $this->input('status');
    }

    public function getPriority()
    {
        return $this->input('priority');
    }
}
