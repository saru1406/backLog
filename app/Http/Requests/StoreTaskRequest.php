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
     * ユーザID取得
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->input('user_id');
    }

    /**
     * タイトル取得
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->input('title');
    }

    /**
     * 内容取得
     *
     * @return string
     */
    public function getContents(): string
    {
        return $this->input('content');
    }

    /**
     * 状態取得
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->input('status');
    }

    /**
     * 優先度取得
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->input('priority');
    }

    /**
     * 開始日取得
     *
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->input('start_date');
    }

    /**
     * 終了日取得
     *
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->input('end_date');
    }
}
