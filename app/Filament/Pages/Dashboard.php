<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Actions\SubscribeAction;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function subscribeAction(): Action
    {
        return SubscribeAction::make()
            ->brandLogo('https://laravel.com/img/logomark.min.svg')
            ->modalHeading(__('Get reals fans faster'))
            ->modalDescription(__('Want to reach more real fans and grow a much bigger and better fan community? Go PRO now!'));
    }
}
