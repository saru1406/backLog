<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'manager' => ['int'],
            'priority' => ['required', 'max:255', 'string'],
            'start_date' => ['nullable', 'max:255', 'string'],
            'end_date' => ['nullable', 'max:255', 'string'],
        ];
    }

    public function getTitle()
    {
        return $this->input('title');
    }

    public function getContents()
    {
        return $this->input('content');
    }

    public function getStatus()
    {
        return $this->input('status');
    }

    public function getPriority()
    {
        return $this->input('priority');
    }

    public function getManager()
    {
        return $this->input('manager');
    }

    public function getStartDate()
    {
        return $this->input('start_date');
    }

    public function getEndDate()
    {
        return $this->input('end_date');
    }
}
