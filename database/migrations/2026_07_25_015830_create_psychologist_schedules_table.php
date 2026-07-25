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
    Schema::create('psychologist_schedules', function (Blueprint $table) {

        $table->id();

        $table->foreignId('psychologist_id')
              ->constrained()
              ->cascadeOnUpdate()
              ->restrictOnDelete();

        // 1 = Senin ... 7 = Minggu
        $table->tinyInteger('day_of_week');

        $table->time('start_time');

        $table->time('end_time');

        // Durasi slot dalam menit
        $table->integer('slot_duration')->default(60);

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
        Schema::dropIfExists('psychologist_schedules');
    }
};
