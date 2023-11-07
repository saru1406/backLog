<?php

namespace App\Http\Requests;

use App\Repositories\ChildTaskParams;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChildTaskRequest extends FormRequest
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
            'user_id' => ['required', 'integer'],
            'title' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'priority' => ['required', 'max:255', 'string'],
            'start_date' => ['nullable', 'max:255', 'string'],
            'end_date' => ['nullable', 'max:255', 'string'],
        ];
    }

    /**
     * @return ChildTaskParams
     */
    public function getParams(): ChildTaskParams
    {
        return new ChildTaskParams(
            $this->input('user_id'),
            $this->input('title'),
            $this->input('content'),
            $this->input('status'),
            $this->input('priority'),
            $this->input('start_date'),
            $this->input('end_date'),
        );
    }
}
