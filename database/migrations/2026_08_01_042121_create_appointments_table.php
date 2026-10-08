<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();

            // Nomor appointment
            $table->string('appointment_no', 30)->unique();

            // Branch
            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Patient
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Psychologist
            $table->foreignId('psychologist_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Psychologist Schedule
            $table->foreignId('psychologist_schedule_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Service
            $table->foreignId('service_rate_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Appointment date & time
            $table->date('appointment_date');
            $table->time('appointment_time');

            // Status
            $table->smallInteger('status')->default(1);

            // Operational notes
            $table->text('notes')->nullable();

            // User who created appointment
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->softDeletes();

            $table->timestamps();

            // Index untuk pencarian/filter
            $table->index([
                'branch_id',
                'appointment_date'
            ]);

            $table->index([
                'psychologist_id',
                'appointment_date'
            ]);

            $table->index([
                'status',
                'appointment_date'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};