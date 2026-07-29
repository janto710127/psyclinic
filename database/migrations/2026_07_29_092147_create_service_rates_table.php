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
        Schema::create('service_rates', function (Blueprint $table) {

            $table->id();

            // Timeline Type
            $table->foreignId('timeline_type_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tarif khusus psikolog (boleh kosong)
            $table->foreignId('psychologist_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('service_code',20)->unique();

            $table->string('service_name',150);

            // durasi dalam menit
            $table->integer('duration')->default(60);

            // tarif
            $table->decimal('price',12,2);

            $table->boolean('is_active')->default(true);

            $table->text('notes')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_rates');
    }
};
