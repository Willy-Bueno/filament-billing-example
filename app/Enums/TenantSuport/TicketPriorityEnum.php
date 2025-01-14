<?php

declare(strict_types=1);

namespace App\Enums\TenantSuport;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TicketPriorityEnum: string implements HasLabel, HasColor
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function getLabel(): string
    {
        return match ($this) {

            self::LOW => 'Baixa',
            self::MEDIUM => 'Média',
            self::HIGH => 'Alta',
            self::URGENT => 'Urgente',

        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {

            self::LOW => 'success',
            self::MEDIUM => 'gray',
            self::HIGH => 'warning',
            self::URGENT => 'danger',

        };
    }
}
