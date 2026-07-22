<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'patient_number' => 'PS' . fake()->unique()->numerify('#####'),

        'name' => fake()->name(),

        'nik' => fake()->numerify('################'),

        'gender' => fake()->randomElement(['L', 'P']),

        'birth_date' => fake()->date(),

        'phone' => fake()->phoneNumber(),

        'email' => fake()->safeEmail(),

        'address' => fake()->address(),

        'occupation' => fake()->jobTitle(),

        'education' => fake()->randomElement([
            'SD',
            'SMP',
            'SMA',
            'D3',
            'S1',
            'S2',
        ]),

        'marital_status' => fake()->randomElement([
            'Belum Menikah',
            'Menikah',
            'Cerai',
        ]),

        'emergency_contact_name' => fake()->name(),

        'emergency_contact_phone' => fake()->phoneNumber(),

        'notes' => fake()->sentence(),
    ];
}
}
