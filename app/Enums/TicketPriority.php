<?php

declare(strict_types=1);

namespace App\Enums;

enum TicketPriority: string
{
    case Baixa = 'baixa';
    case Media = 'media';
    case Alta = 'alta';
    case Critica = 'critica';

    public function label(): string
    {
        return match($this) {
            self::Baixa => 'Baixa',
            self::Media => 'Média',
            self::Alta => 'Alta',
            self::Critica => 'Crítica',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Baixa => 'bg-gray-100 text-gray-800',
            self::Media => 'bg-blue-100 text-blue-800',
            self::Alta => 'bg-orange-100 text-orange-800',
            self::Critica => 'bg-red-100 text-red-800',
        };
    }

    public function order(): int
    {
        return match($this) {
            self::Baixa => 1,
            self::Media => 2,
            self::Alta => 3,
            self::Critica => 4,
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}
