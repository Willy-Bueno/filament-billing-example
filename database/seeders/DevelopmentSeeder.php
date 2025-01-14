<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '$2y$12$rXHn4Vchoy91KuZdFB6VG.kNxYiyClG/Dh2oOQCQC/h8WZHKdrVl6',
            'remember_token' => '5NTlKi8O3tWSAt1W7Q5gIiXSLsQvJ1ebcPRASGG9u98jVyV7am1Kh3FBQHNT',
            'is_admin' => true,

        ]);
    }
}
