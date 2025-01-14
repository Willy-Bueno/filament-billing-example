<?php

declare(strict_types=1);

namespace App\Data\Cashier;

use App\Models\Team;

use function App\Support\tenant;

use Filament\Pages\Dashboard;
use Illuminate\Support\Arr;
use InvalidArgumentException;

readonly class Stripe
{
    private function __construct(
        private int $trialDays,
        private bool $allowPromotionCodes,
        private array $billedPeriods,
        private array $plans
    ) {
    }

    public static function fromConfig(): self
    {
        return new self(
            trialDays: config('stripe.trial_days'),
            allowPromotionCodes: config('stripe.allow_promotion_codes'),
            billedPeriods: config('stripe.billed_periods'),
            plans: config('stripe.plans'),
        );
    }

    public function trialDays(): int
    {
        return $this->trialDays;
    }

    public function allowPromotionCodes(): bool
    {
        return $this->allowPromotionCodes;
    }

    /**
     * @return array<Plan>
     */
    public function plans(): array
    {
        return array_map(
            fn (array $plan, string $key) => Plan::fromArray($plan, $key),
            $this->plans,
            array_keys($this->plans)
        );
    }

    public function billedPeriods(): array
    {
        return $this->billedPeriods;
    }

    public function checkoutUrl(string $period): void
    {

        $plan = Arr::first($this->plans());

        if (! $plan) {
            throw new InvalidArgumentException('Plan not configured');
        }

        /** @var Price|null $price */
        $price = collect($plan->prices())
           ->first(fn (Price $price) => $price->period() === $period);

        if (! $price) {
            throw new InvalidArgumentException("Price not found for period: {$period}");
        }

        $tenant = tenant(Team::class);

        $tenant->newSubscription($plan->type(), $price->id())
            ->checkout([
                'success_url' => Dashboard::getUrl(),
                'cancel_url' => Dashboard::getUrl(),
            ])
            ->redirect();
    }
}
