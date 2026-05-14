<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Support\TicketNumberGenerator;

class TicketService
{
    public function create(StoreTicketRequest $request, User $requester): Ticket
    {
        return Ticket::create([
            'number' => TicketNumberGenerator::generate(),
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'status' => TicketStatus::Aberto,
            'priority' => $request->validated('priority'),
            'category_id' => $request->validated('category_id'),
            'requester_id' => $requester->id,
            'assignee_id' => $request->validated('assignee_id'),
            'due_date' => $request->validated('due_date'),
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): Ticket
    {
        $data = $request->validated();

        if (isset($data['status'])) {
            $closingStatuses = [TicketStatus::Resolvido, TicketStatus::Fechado];
            $isClosing = in_array($data['status'], $closingStatuses);
            $wasOpen = ! $ticket->isClosed();

            if ($isClosing && $wasOpen) {
                $data['closed_at'] = now();
            } elseif (! $isClosing) {
                $data['closed_at'] = null;
            }
        }

        $ticket->update($data);

        return $ticket->refresh();
    }

    public function stats(): array
    {
        return [
            'total' => Ticket::count(),
            'abertos' => Ticket::where('status', TicketStatus::Aberto)->count(),
            'em_andamento' => Ticket::where('status', TicketStatus::EmAndamento)->count(),
            'resolvidos' => Ticket::where('status', TicketStatus::Resolvido)->count(),
            'criticos' => Ticket::where('priority', 'critica')
                ->whereNotIn('status', [TicketStatus::Resolvido, TicketStatus::Fechado])
                ->count(),
        ];
    }
}
