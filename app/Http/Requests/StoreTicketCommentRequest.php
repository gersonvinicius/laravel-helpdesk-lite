<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'min:2', 'max:5000'],
            'internal' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'O comentário não pode estar vazio.',
            'body.min' => 'O comentário deve ter pelo menos 2 caracteres.',
        ];
    }
}
