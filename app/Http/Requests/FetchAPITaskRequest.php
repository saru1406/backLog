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


    /**
     * ユーザID取得
     *
     * @return integer|null
     */
    public function getUserId(): ?int
    {
        return $this->query('user_id');
    }

    /**
     * 状態取得
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->query('status');
    }

    /**
     * 優先度取得
     *
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return $this->query('priority');
    }
}
