<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Repositories\ApiGantParams;
use Illuminate\Foundation\Http\FormRequest;

class FetchApiGantRequest extends FormRequest
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
            'status' => ['nullable', 'string'],
            'start_date' => ['nullable', 'string'],
            'group' => ['nullable', 'string'],
            'range' => ['nullable', 'integer'],
        ];
    }

    /**
     * @return ApiGantParams
     */
    public function getParams(): ApiGantParams
    {
        return new ApiGantParams(
            status: $this->input('status'),
            startDate: $this->input('start_date'),
            group: $this->input('group'),
            range: (int) $this->input('range'),
        );
    }
}
