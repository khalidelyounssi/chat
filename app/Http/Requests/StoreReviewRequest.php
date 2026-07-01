<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'comment' => trim((string) $this->input('comment')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1200'],
            'website' => ['nullable', 'prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Votre prenom ou votre nom est requis.',
            'rating.required' => 'Choisissez une note entre 1 et 5 etoiles.',
            'rating.between' => 'La note doit etre comprise entre 1 et 5 etoiles.',
            'comment.required' => 'Ecrivez votre commentaire.',
            'comment.min' => 'Votre commentaire doit contenir au moins 10 caracteres.',
            'comment.max' => 'Votre commentaire ne peut pas depasser 1200 caracteres.',
        ];
    }
}
