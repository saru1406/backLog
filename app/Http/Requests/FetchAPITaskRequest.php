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
            'is_pagination' => ['nullable', 'boolean']
        ];
    }


    /**
     * ユーザID取得
     *
     * @return int|null
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

    /**
     * ページネーションで取得の有無
     *
     * @return boolean
     */
    public function getIsPagination(): bool
    {
        return $this->input('is_pagination', true);
    }
}
