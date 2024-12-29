<?php

declare(strict_types=1);

namespace App\Support;

/**
 * This file contains helper functions
 *
 * The `tenant` function is based on code by Saade:
 * https://gist.github.com/saade/a4bffa843cd55ce1ea8b8161d1f0ce18#file-helpers-php
 *
 * Credits to the original author: Saade
 */

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

if (! function_exists('tenant')) {
    /**
     * @template TValue of Model
     *
     * @param class-string<TValue> $class
     * @param string|null $attribute
     *
     * @return ($attribute is null ? TValue|null : mixed)
     */
    function tenant(string $class, ?string $attribute = null): mixed
    {
        return once(static function () use ($class, $attribute) {
            $tenant = Filament::getTenant();

            if (! $tenant instanceof $class) {
                return null;
            }

            if ($attribute === null) {
                return $tenant;
            }

            /** @var TValue $tenant */
            return $tenant->getAttribute($attribute);
        });
    }
}
