<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin() || $user->isAtendente()) {
            return true;
        }

        return $ticket->requester_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAtendente()) {
            return true;
        }

        return $ticket->requester_id === $user->id && ! $ticket->isClosed();
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    public function comment(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin() || $user->isAtendente()) {
            return true;
        }

        return $ticket->requester_id === $user->id;
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin() || $user->isAtendente();
    }

    public function changeStatus(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin() || $user->isAtendente();
    }
}
