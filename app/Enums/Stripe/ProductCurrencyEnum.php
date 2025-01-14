<?php

declare(strict_types=1);

namespace App\Enums\Stripe;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProductCurrencyEnum: string implements HasLabel, HasColor
{
    case BRL = 'brl';
    case EUR = 'eur';
    case USD = 'usd';

    public function getLabel(): string
    {
        return match ($this) {
            self::BRL => 'Real',
            self::EUR => 'Euro',
            self::USD => 'Dolar',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BRL => 'success',
            self::EUR => 'success',
            self::USD => 'success',
        };
    }
}
