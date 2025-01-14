<?php

declare(strict_types=1);

namespace App\Enums\TenantSuport;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TicketStatusEnum: string implements HasLabel, HasColor
{
    case OPEN = 'open';
    case INPROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    public function getLabel(): string
    {
        return match ($this) {

            self::OPEN => 'Aberto',
            self::INPROGRESS => 'Em Progresso',
            self::RESOLVED => 'Resolvido',
            self::CLOSED => 'Fechado',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {

            self::OPEN => 'gray',
            self::INPROGRESS => 'warning',
            self::RESOLVED => 'success',
            self::CLOSED => 'danger',
        };
    }
}
