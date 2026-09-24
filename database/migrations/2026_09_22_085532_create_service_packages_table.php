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
        Schema::create('service_packages', function (Blueprint $table) {

            $table->id();

            // Kode paket
            $table->string('package_code', 20)->unique();

            // Nama paket
            $table->string('package_name', 150);

            // Harga jual paket
            $table->decimal('price', 12, 2);

            // Masa berlaku paket dalam hari
            $table->integer('validity_days')->nullable();

            // Status aktif
            $table->boolean('is_active')->default(true);

            // Keterangan
            $table->text('notes')->nullable();

            // Soft delete
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};