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
        Schema::create('service_package_details', function (Blueprint $table) {

            $table->id();

            // Package
            $table->foreignId('service_package_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Service Rate
            $table->foreignId('service_rate_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Jumlah sesi layanan
            $table->integer('quantity')->default(1);

            // Snapshot harga service saat package dibuat
            $table->decimal('price', 12, 2);

            // Catatan
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_package_details');
    }
};