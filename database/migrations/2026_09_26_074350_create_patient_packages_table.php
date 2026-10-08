<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_packages', function (Blueprint $table) {

            $table->id();

            // Nomor kepemilikan paket pasien
            $table->string('patient_package_no', 30)->unique();

            // Patient
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Master Package
            $table->foreignId('service_package_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Snapshot harga saat pasien membeli paket
            $table->decimal('price', 12, 2);

            // Tanggal pembelian
            $table->date('purchased_at');

            // Mulai berlaku
            $table->date('started_at')->nullable();

            // Tanggal berakhir
            $table->date('expired_at')->nullable();

            // Status
            $table->smallInteger('status')->default(1);

            // Catatan
            $table->text('notes')->nullable();

            $table->softDeletes();

            $table->timestamps();

            $table->index([
                'patient_id',
                'status'
            ]);

            $table->index([
                'service_package_id',
                'status'
            ]);

            $table->index('expired_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_packages');
    }
};