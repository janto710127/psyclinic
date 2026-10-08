<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_package_usages', function (Blueprint $table) {

            $table->id();

            // Patient Package
            $table->foreignId('patient_package_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Detail layanan dari package
            $table->foreignId('service_package_detail_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Appointment yang menggunakan paket
            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tanggal penggunaan
            $table->date('used_at');

            // Jumlah penggunaan
            $table->integer('quantity')->default(1);

            // Snapshot harga layanan
            $table->decimal('price', 12, 2)->nullable();

            // Catatan
            $table->text('notes')->nullable();

            $table->timestamps();

            // Index dengan nama pendek
            $table->index(
                ['patient_package_id', 'service_package_detail_id'],
                'ppu_package_detail_idx'
            );

            $table->index(
                'appointment_id',
                'ppu_appointment_idx'
            );

            $table->index(
                'used_at',
                'ppu_used_at_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_package_usages');
    }
};