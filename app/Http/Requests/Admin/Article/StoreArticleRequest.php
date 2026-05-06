<?php

namespace App\Http\Requests\Admin\Article;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'content' => ['required', 'array'],
            'content.type' => ['required', 'string', 'in:doc'],
            'content.content' => ['required', 'array'],
        ];
    }
}
