<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'title',
        'description',
        'status',
        'priority',
        'category_id',
        'requester_id',
        'assignee_id',
        'due_date',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
            'priority' => TicketPriority::class,
            'due_date' => 'date',
            'closed_at' => 'datetime',
        ];
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class)->orderBy('created_at');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', TicketStatus::Aberto);
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', TicketStatus::EmAndamento);
    }

    public function scopeResolved(Builder $query): Builder
    {
        return $query->where('status', TicketStatus::Resolvido);
    }

    public function scopeCritical(Builder $query): Builder
    {
        return $query->where('priority', TicketPriority::Critica);
    }

    public function isClosed(): bool
    {
        return in_array($this->status, [TicketStatus::Resolvido, TicketStatus::Fechado]);
    }
}
