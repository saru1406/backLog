<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Repositories\ApiTaskParams;
use Illuminate\Foundation\Http\FormRequest;

class FetchApiTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function validationData()
    {
        $params = $this->only(['is_pagination']);

        if (isset($params['is_pagination'])) {
            $params['is_pagination'] = $this->boolean('is_pagination');
            $this->merge($params);
        }

        return $params;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'int'],
            'status' => ['nullable', 'string'],
            'priority' => ['nullable', 'string'],
            'is_pagination' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return ApiTaskParams
     */
    public function getParams(): ApiTaskParams
    {
        return new ApiTaskParams(
            userId: $this->input('user_id'),
            status: $this->input('status'),
            priority: $this->input('priority'),
            isPagination: $this->input('is_pagination', true),
        );
    }
}
