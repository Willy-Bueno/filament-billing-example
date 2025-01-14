<?php

declare(strict_types=1);

return [
    'trial_days' => 7,

    'allow_promotion_codes' => true,

    'billed_periods' => [
        'monthly' => 'Monthly',
        'yearly' => 'Yearly',
    ],

    'plans' => [
        'default' => [
            'type' => 'default',
            'name' => 'Standard',
            'short_description' => 'A standard plan',
            'product_id' => 'prod_ROpr8d2MK9Vfk5',
            'prices' => [
                'monthly' => [
                    'period' => 'monthly',
                    'id' => 'price_1QW2CALA7pUbGHxdRWGLtvYv',
                    'price' => 7900,
                ],
                'yearly' => [
                    'period' => 'yearly',
                    'id' => 'price_1QW2CqLA7pUbGHxdWwEGyK4D',
                    'price' => 79000,
                ],
            ],
            'features' => [
                'Grow fans and followers on multiple social platforms',
                'Promote more content with email automation',
                'Showcase your content to thousands of fans in New Finds',
            ],
        ],
    ],
];
