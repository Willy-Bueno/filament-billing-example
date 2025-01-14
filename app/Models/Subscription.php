<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Stripe\SubscriptionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $casts = [
        'stripe_status' => SubscriptionStatusEnum::class,
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
