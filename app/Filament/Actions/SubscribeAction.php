<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Data\Cashier\Stripe;
use App\Forms\Components\RadioGroup;
use Closure;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;

class SubscribeAction extends Action
{
    protected string | HtmlString | Closure | null $brandLogo = null;

    protected string | Htmlable | Closure | null $heading = null;

    protected string | Htmlable | Closure | null $subheading = null;

    protected function setUp(): void
    {
        $this->name('subscribe');

        $this->modalWidth(MaxWidth::Large);

        $this->modalContent(view('filament.actions.subscribe.header', $this->extractPublicMethods()));

        $this->form([
            RadioGroup::make('billing_period')
                ->label(__('Select your plan'))
                ->options(Stripe::fromConfig()->billedPeriods())
                ->default(array_key_first(Stripe::fromConfig()->billedPeriods()))
                ->columnSpanFull()
                ->badges([
                    'annually' => __('Best Value'),
                ]),
        ]);

        $this->registerModalActions([
            Action::make('checkout')
                ->label(__('Go PRO now'))
                ->size('xl')
                ->extraAttributes(['class' => 'w-full'])
                ->action(function (Action $action) {
                    $actions = $action->getLivewire()->mountedActionsData;

                    $billingPeriod = data_get(Arr::first($actions), 'billing_period');

                    Stripe::fromConfig()->checkoutUrl($billingPeriod);
                }),
        ]);

        $this->modalContentFooter(function (Action $action): View {
            return view('filament.actions.subscribe.footer', [
                ...$this->extractPublicMethods(),
                'action' => $action,
            ]);
        });

        $this->closeModalByClickingAway(false);

        $this->closeModalByEscaping(false);

        $this->modalCloseButton(false);

        $this->modalCancelAction(false);

        $this->modalSubmitAction(false);

        $this->extraModalWindowAttributes([
            'class' => '[&_.fi-modal-header]:hidden bg-gradient-to-b from-indigo-500/10 from-0% to-indigo-500/0 to-30%',
        ]);
    }

    public function brandLogo(string|Htmlable|Closure|null $logo): static
    {
        $this->brandLogo = $logo;

        return $this;
    }

    public function getBrandLogo(): string | Htmlable | null
    {
        return $this->evaluate($this->brandLogo);
    }
}
