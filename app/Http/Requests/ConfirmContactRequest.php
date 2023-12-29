<?php

namespace App\Http\Requests;

use App\Repositories\ContactParams;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }

    public function getParams()
    {
        return new ContactParams(
            category: $this->input('category'),
            content: $this->input('content'),
        );
    }
}
