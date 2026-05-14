<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly TicketService $ticketService)
    {
    }

    public function __invoke(): View
    {
        $stats = $this->ticketService->stats();

        $recentTickets = Ticket::with(['requester', 'assignee', 'category'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('dashboard', compact('stats', 'recentTickets'));
    }
}
