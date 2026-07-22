<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TimelineTypeSeeder::class,
        ]);

        Patient::factory()
            ->count(100)
            ->create();
    }
}