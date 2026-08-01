<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();

            // Nomor Appointment
            $table->string('appointment_no')->unique();

            // Pasien
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Psikolog
            $table->foreignId('psychologist_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Jadwal Praktik
            $table->foreignId('psychologist_schedule_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tarif
            $table->foreignId('service_rate_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tanggal Appointment
            $table->date('appointment_date');

            // Jam Appointment
            $table->time('appointment_time');

            // Status
            $table->tinyInteger('status')->default(1);

            // Catatan
            $table->text('notes')->nullable();

            // User yang membuat
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
