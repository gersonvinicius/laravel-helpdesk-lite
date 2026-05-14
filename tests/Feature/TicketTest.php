<?php

use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

// ==================== Enum Tests ====================

test('TicketStatus has all expected cases', function () {
    $cases = TicketStatus::cases();
    $values = array_column($cases, 'value');

    expect($values)->toContain('aberto')
        ->toContain('em_andamento')
        ->toContain('aguardando_resposta')
        ->toContain('resolvido')
        ->toContain('fechado');
});

test('TicketStatus label returns Portuguese text', function () {
    expect(TicketStatus::Aberto->label())->toBe('Aberto')
        ->and(TicketStatus::EmAndamento->label())->toBe('Em Andamento')
        ->and(TicketStatus::Resolvido->label())->toBe('Resolvido');
});

test('TicketStatus badgeClass returns non-empty string', function () {
    foreach (TicketStatus::cases() as $status) {
        expect($status->badgeClass())->toBeString()->not->toBeEmpty();
    }
});

test('TicketPriority has all expected cases', function () {
    $values = array_column(\App\Enums\TicketPriority::cases(), 'value');
    expect($values)->toContain('baixa')->toContain('media')->toContain('alta')->toContain('critica');
});

test('TicketPriority label returns Portuguese text', function () {
    expect(\App\Enums\TicketPriority::Alta->label())->toBe('Alta')
        ->and(\App\Enums\TicketPriority::Critica->label())->toBe('Crítica');
});

test('UserRole has admin atendente solicitante', function () {
    $values = array_column(UserRole::cases(), 'value');
    expect($values)->toContain('admin')->toContain('atendente')->toContain('solicitante');
});

// ==================== Dashboard ====================

test('dashboard requires authentication', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('authenticated user can access dashboard', function () {
    $user = User::factory()->create(['role' => UserRole::Solicitante]);
    $this->actingAs($user)->get(route('dashboard'))->assertOk();
});

// ==================== Ticket CRUD ====================

test('ticket index is accessible to authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('tickets.index'))->assertOk();
});

test('ticket index requires authentication', function () {
    $this->get(route('tickets.index'))->assertRedirect(route('login'));
});

test('solicitante can create a ticket', function () {
    $user = User::factory()->create(['role' => UserRole::Solicitante]);
    $category = Category::factory()->create();

    $this->actingAs($user)->post(route('tickets.store'), [
        'title' => 'Problema no sistema de login',
        'description' => 'Não consigo acessar o sistema de login desde ontem.',
        'priority' => 'media',
        'category_id' => $category->id,
    ])->assertRedirect();

    $this->assertDatabaseHas('tickets', [
        'title' => 'Problema no sistema de login',
        'requester_id' => $user->id,
    ]);
});

test('ticket store validates required fields', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->post(route('tickets.store'), [])->assertSessionHasErrors(['title', 'description', 'priority']);
});

test('ticket number is generated on creation', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->post(route('tickets.store'), [
        'title' => 'Título do chamado teste',
        'description' => 'Descrição detalhada do problema encontrado.',
        'priority' => 'baixa',
    ]);

    $ticket = Ticket::latest()->first();
    expect($ticket->number)->toStartWith('HD-');
});

test('admin can update any ticket', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create(['status' => TicketStatus::Aberto]);

    $this->actingAs($admin)->patch(route('tickets.update', $ticket), [
        'title' => $ticket->title,
        'description' => $ticket->description,
        'status' => 'em_andamento',
        'priority' => $ticket->priority->value,
    ])->assertRedirect();

    expect($ticket->fresh()->status)->toBe(TicketStatus::EmAndamento);
});

test('solicitante cannot update another users ticket', function () {
    $user1 = User::factory()->create(['role' => UserRole::Solicitante]);
    $user2 = User::factory()->create(['role' => UserRole::Solicitante]);
    $ticket = Ticket::factory()->create(['requester_id' => $user2->id]);

    $this->actingAs($user1)->patch(route('tickets.update', $ticket), [
        'title' => 'Titulo alterado',
        'description' => 'Descricao alterada',
        'priority' => 'baixa',
        'status' => 'aberto',
    ])->assertForbidden();
});

test('admin can delete a ticket', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    $this->actingAs($admin)->delete(route('tickets.destroy', $ticket))->assertRedirect();
    $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
});

test('solicitante cannot delete a ticket', function () {
    $user = User::factory()->create(['role' => UserRole::Solicitante]);
    $ticket = Ticket::factory()->create(['requester_id' => $user->id]);

    $this->actingAs($user)->delete(route('tickets.destroy', $ticket))->assertForbidden();
});

// ==================== Comments ====================

test('user can add a comment to a ticket', function () {
    $user = User::factory()->create(['role' => UserRole::Solicitante]);
    $ticket = Ticket::factory()->create(['requester_id' => $user->id]);

    $this->actingAs($user)->post(route('tickets.comments.store', $ticket), [
        'body' => 'Ainda está acontecendo o problema.',
    ])->assertRedirect();

    $this->assertDatabaseHas('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'body' => 'Ainda está acontecendo o problema.',
    ]);
});

test('comment body is required', function () {
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['requester_id' => $user->id]);

    $this->actingAs($user)->post(route('tickets.comments.store', $ticket), [
        'body' => '',
    ])->assertSessionHasErrors('body');
});

test('only admin and atendente can create internal comments', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create(['requester_id' => $admin->id]);

    $this->actingAs($admin)->post(route('tickets.comments.store', $ticket), [
        'body' => 'Nota interna para a equipe.',
        'internal' => '1',
    ])->assertRedirect();

    $this->assertDatabaseHas('ticket_comments', ['body' => 'Nota interna para a equipe.', 'internal' => true]);
});

// ==================== Ticket show ====================

test('requester can view their own ticket', function () {
    $user = User::factory()->create(['role' => UserRole::Solicitante]);
    $ticket = Ticket::factory()->create(['requester_id' => $user->id]);

    $this->actingAs($user)->get(route('tickets.show', $ticket))->assertOk();
});

test('solicitante cannot view another users ticket', function () {
    $user1 = User::factory()->create(['role' => UserRole::Solicitante]);
    $user2 = User::factory()->create(['role' => UserRole::Solicitante]);
    $ticket = Ticket::factory()->create(['requester_id' => $user2->id]);

    $this->actingAs($user1)->get(route('tickets.show', $ticket))->assertForbidden();
});

test('admin can view any ticket', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $ticket = Ticket::factory()->create();

    $this->actingAs($admin)->get(route('tickets.show', $ticket))->assertOk();
});
