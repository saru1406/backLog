<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Repositories\ChildTaskParams;
use Illuminate\Foundation\Http\FormRequest;

class StoreChildTaskRequest extends FormRequest
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
            'content' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'priority' => ['nullable', 'max:255', 'string'],
            'branch_name' => ['nullable', 'max:255', 'string'],
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
            userId: $this->input('user_id'),
            title: $this->input('title'),
            contents: $this->input('content'),
            status: $this->input('status'),
            priority: $this->input('priority'),
            branchName: $this->input('branch_name'),
            startDate: $this->input('start_date'),
            endDate: $this->input('end_date'),
        );
    }
}
