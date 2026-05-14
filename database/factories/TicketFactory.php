<?php

namespace Database\Factories;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Support\TicketNumberGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'number' => TicketNumberGenerator::generate(),
            'title' => fake()->sentence(6),
            'description' => fake()->paragraph(3),
            'status' => TicketStatus::Aberto,
            'priority' => fake()->randomElement(TicketPriority::cases()),
            'requester_id' => User::factory(),
            'assignee_id' => null,
            'category_id' => null,
            'due_date' => null,
            'closed_at' => null,
        ];
    }
}
