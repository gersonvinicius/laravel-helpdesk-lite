<?php

declare(strict_types=1);

namespace App\Enums;

enum TicketStatus: string
{
    case Aberto = 'aberto';
    case EmAndamento = 'em_andamento';
    case AguardandoResposta = 'aguardando_resposta';
    case Resolvido = 'resolvido';
    case Fechado = 'fechado';

    public function label(): string
    {
        return match($this) {
            self::Aberto => 'Aberto',
            self::EmAndamento => 'Em Andamento',
            self::AguardandoResposta => 'Aguardando Resposta',
            self::Resolvido => 'Resolvido',
            self::Fechado => 'Fechado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Aberto => 'blue',
            self::EmAndamento => 'yellow',
            self::AguardandoResposta => 'purple',
            self::Resolvido => 'green',
            self::Fechado => 'gray',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Aberto => 'bg-blue-100 text-blue-800',
            self::EmAndamento => 'bg-yellow-100 text-yellow-800',
            self::AguardandoResposta => 'bg-purple-100 text-purple-800',
            self::Resolvido => 'bg-green-100 text-green-800',
            self::Fechado => 'bg-gray-100 text-gray-800',
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
