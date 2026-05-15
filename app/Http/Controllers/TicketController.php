<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketCommentRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $ticketService)
    {
    }

    public function index(): View
    {
        $this->authorize('viewAny', Ticket::class);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tickets = Ticket::with(['requester', 'assignee', 'category', 'tags'])
            ->when(! $user->isAtendente(), fn ($q) => $q->where('requester_id', $user->id))
            ->when(request('search'), fn ($q, $s) => $q->where(fn ($q) => $q->where('title', 'like', "%{$s}%")->orWhere('description', 'like', "%{$s}%")))
            ->when(request('status'), fn ($q, $s) => $q->where('status', $s))
            ->when(request('priority'), fn ($q, $p) => $q->where('priority', $p))
            ->when(request('assignee_id'), fn ($q, $a) => $q->where('assignee_id', $a))
            ->when(request('category_id'), fn ($q, $c) => $q->where('category_id', $c))
            ->when(request('tag_id'), fn ($q, $t) => $q->whereHas('tags', fn ($q) => $q->where('tags.id', $t)))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::where('active', true)->orderBy('name')->get();
        $atendentes = User::whereIn('role', ['admin', 'atendente'])->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('tickets.index', compact('tickets', 'categories', 'atendentes', 'tags'));
    }

    public function create(): View
    {
        $this->authorize('create', Ticket::class);

        $categories = Category::where('active', true)->orderBy('name')->get();
        $atendentes = User::whereIn('role', ['admin', 'atendente'])->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('tickets.create', compact('categories', 'atendentes', 'tags'));
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $this->authorize('create', Ticket::class);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $ticket = $this->ticketService->create($request, $user);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', "Chamado {$ticket->number} criado com sucesso!");
    }

    public function show(Ticket $ticket): View
    {
        $this->authorize('view', $ticket);

        $ticket->load(['requester', 'assignee', 'category', 'comments.user', 'tags']);

        $categories = Category::where('active', true)->orderBy('name')->get();
        $atendentes = User::whereIn('role', ['admin', 'atendente'])->orderBy('name')->get();

        return view('tickets.show', compact('ticket', 'categories', 'atendentes'));
    }

    public function edit(Ticket $ticket): View
    {
        $this->authorize('update', $ticket);

        $categories = Category::where('active', true)->orderBy('name')->get();
        $atendentes = User::whereIn('role', ['admin', 'atendente'])->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('tickets.edit', compact('ticket', 'categories', 'atendentes', 'tags'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('update', $ticket);

        $this->ticketService->update($request, $ticket);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Chamado atualizado com sucesso!');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', "Chamado {$ticket->number} removido com sucesso.");
    }

    public function storeComment(StoreTicketCommentRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('comment', $ticket);

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'body'      => clean($request->validated('body')),
            'internal'  => (bool) $request->validated('internal', false),
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Comentário adicionado com sucesso!');
    }
}
