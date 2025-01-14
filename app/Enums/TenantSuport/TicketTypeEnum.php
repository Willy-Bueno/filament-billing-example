<?php

declare(strict_types=1);

namespace App\Enums\TenantSuport;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TicketTypeEnum: string implements HasLabel, HasColor
{
    case PROBLEM = 'problem';
    case ENHANCEMENT = 'enhancement';

    public function getLabel(): string
    {
        return match ($this) {
            self::PROBLEM => 'Problema',
            self::ENHANCEMENT => 'Melhoria',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PROBLEM => 'danger',
            self::ENHANCEMENT => 'success',
        };
    }
}
