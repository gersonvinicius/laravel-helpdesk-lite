<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Ticket;

class TicketNumberGenerator
{
    public static function generate(): string
    {
        $year = now()->format('Y');
        $lastTicket = Ticket::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $sequence = $lastTicket
            ? ((int) substr($lastTicket->number, -4)) + 1
            : 1;

        return sprintf('HD-%s-%04d', $year, $sequence);
    }
}
