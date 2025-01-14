<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $color = Auth::user()->settings['color'] ?? config('filament.theme.colors.primary');
        FilamentColor::register([
            'primary' => $color,
        ]);

        return $next($request);
    }
}
