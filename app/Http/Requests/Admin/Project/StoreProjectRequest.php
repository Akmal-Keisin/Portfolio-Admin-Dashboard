<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'live_url' => ['nullable', 'url', 'max:255'],
            'repo_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'in:ongoing,completed'],
            'featured' => ['required', 'boolean'],
            'tech_stacks' => ['nullable', 'array'],
            'tech_stacks.*' => ['exists:tech_stacks,id'],
        ];
    }
}
