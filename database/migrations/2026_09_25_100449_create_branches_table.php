<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {

            $table->id();

            // Organization induk
            $table->foreignId('organization_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Kode Branch
            $table->string('branch_code', 20);

            // Nama Branch
            $table->string('branch_name', 150);

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

            // Kode branch unik dalam satu organization
            $table->unique([
                'organization_id',
                'branch_code'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};