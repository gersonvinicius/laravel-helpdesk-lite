<?php

namespace App\Http\Requests;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', function ($attribute, $value, $fail) {
                if (mb_strlen(strip_tags($value)) < 10) {
                    $fail('A descrição deve ter pelo menos 10 caracteres.');
                }
            }],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'assignee_id' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve ter pelo menos 5 caracteres.',
            'description.required' => 'A descrição é obrigatória.',
            'priority.required' => 'A prioridade é obrigatória.',
            'due_date.after_or_equal' => 'A data limite não pode ser no passado.',
        ];
    }
}
