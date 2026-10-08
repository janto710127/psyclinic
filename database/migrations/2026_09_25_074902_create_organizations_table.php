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
    Schema::create('organizations', function (Blueprint $table) {

        $table->id();

        // Kode Organization
        $table->string('organization_code', 20)
            ->unique();

        // Nama Organization
        $table->string('organization_name', 150);

        // Alamat
        $table->text('address')->nullable();

        // Telepon
        $table->string('phone', 30)->nullable();

        // Email
        $table->string('email', 150)->nullable();

        // Status
        $table->boolean('is_active')->default(true);

        // Catatan
        $table->text('notes')->nullable();

        // Soft Delete
        $table->softDeletes();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
