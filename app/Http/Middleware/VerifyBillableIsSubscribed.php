<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Data\Cashier\Stripe;
use App\Models\Team;

use function App\Support\tenant;

use Closure;
use Filament\Pages\Dashboard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyBillableIsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant(Team::class);

        $stripeConfig = Stripe::fromConfig();

        foreach ($stripeConfig->plans() as $plan) {
            if ($tenant->subscribedToProduct($plan->productId())) {
                return $next($request);
            }
        }

        if ($request->getQueryString() === 'action=subscribe') {
            return $next($request);
        }

        return redirect(Dashboard::getUrl(['action' => 'subscribe']));
    }
}
