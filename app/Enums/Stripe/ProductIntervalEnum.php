<?php

declare(strict_types=1);

namespace App\Enums\Stripe;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProductIntervalEnum: string implements HasLabel, HasColor
{
    case YEAR = 'year';
    case MONTH = 'month';
    case WEEK = 'week';
    case DAY = 'day';

    public function getLabel(): string
    {
        return match ($this) {
            self::YEAR => 'Anual',
            self::MONTH => 'Mensal',
            self::WEEK => 'Semanal',
            self::DAY => 'Diaria',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::YEAR => 'success',
            self::MONTH => 'success',
            self::WEEK => 'success',
            self::DAY => 'success',
        };
    }
}
