<?php

namespace Database\Seeders;

use App\Models\TimelineType;
use Illuminate\Database\Seeder;

class TimelineTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Registrasi',
                'code' => 'registration',
            ],
            [
                'name' => 'Konsultasi',
                'code' => 'consultation',
            ],
            [
                'name' => 'Terapi',
                'code' => 'therapy',
            ],
            [
                'name' => 'Tes Psikologi',
                'code' => 'psychological_test',
            ],
            [
                'name' => 'Catatan',
                'code' => 'note',
            ],
            [
                'name' => 'Pembayaran',
                'code' => 'payment',
            ],
        ];

        foreach ($types as $type) {
            TimelineType::updateOrCreate($type);
        }
    }
}