<?php

namespace App\Http\Controllers\Api;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TicketApiController extends Controller
{
    public function __construct(private readonly TicketService $ticketService)
    {
    }

    public function index(): JsonResponse
    {
        $tickets = Ticket::with(['requester:id,name', 'assignee:id,name', 'category:id,name'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($tickets);
    }

    public function show(Ticket $ticket): JsonResponse
    {
        $ticket->load(['requester:id,name,email', 'assignee:id,name,email', 'category:id,name', 'comments.user:id,name']);

        return response()->json($ticket);
    }

    public function store(StoreTicketRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $ticket = $this->ticketService->create($request, $user);

        return response()->json($ticket->load(['requester:id,name', 'category:id,name']), 201);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $ticket = $this->ticketService->update($request, $ticket);

        return response()->json($ticket->load(['requester:id,name', 'assignee:id,name', 'category:id,name']));
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->ticketService->stats());
    }
}
