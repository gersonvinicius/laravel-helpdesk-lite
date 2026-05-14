<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Atendente = 'atendente';
    case Solicitante = 'solicitante';

    public function label(): string
    {
        return match($this) {
            self::Admin => 'Administrador',
            self::Atendente => 'Atendente',
            self::Solicitante => 'Solicitante',
        };
    }
}
