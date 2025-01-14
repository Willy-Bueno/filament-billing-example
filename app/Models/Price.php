<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Stripe\ProductCurrencyEnum;
use App\Enums\Stripe\ProductIntervalEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'stripe_price_id',
        'currency',
        'is_active',
        'interval',
        'unit_amount',
    ];

    protected $casts = [
        'interval' => ProductIntervalEnum::class,
        'currency' => ProductCurrencyEnum::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
