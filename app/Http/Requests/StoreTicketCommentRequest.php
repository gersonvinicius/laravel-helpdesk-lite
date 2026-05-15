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
            'body' => ['required', 'string', 'max:10000', function ($attribute, $value, $fail) {
                if (mb_strlen(strip_tags($value)) < 2) {
                    $fail('O comentário deve ter pelo menos 2 caracteres.');
                }
            }],
            'internal' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'O comentário não pode estar vazio.',
        ];
    }
}
