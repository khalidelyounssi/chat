<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'category_id' => $this->filled('category_id') ? (int) $this->input('category_id') : null,
            'breed' => $this->filled('breed') ? trim((string) $this->input('breed')) : 'Abyssin',
            'remove_image' => $this->boolean('remove_image'),
            'remove_gallery' => $this->boolean('remove_gallery'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0', 'max:30'],
            'gender' => ['required', 'in:male,female'],
            'breed' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:20'],
            'status' => ['required', 'in:available,reserved,sold'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'remove_image' => ['nullable', 'boolean'],
            'remove_gallery' => ['nullable', 'boolean'],
        ];
    }
}
