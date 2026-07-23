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
        Schema::create('psychologists', function (Blueprint $table) {

            $table->id();

            $table->string('psychologist_code')->unique();

            $table->string('name');

            $table->enum('gender', [
                'L',
                'P'
            ]);

            $table->string('phone')->nullable();

            $table->string('email')->nullable();

            $table->string('sip_number')->nullable();

            $table->string('str_number')->nullable();

            $table->string('specialization')->nullable();

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
        Schema::dropIfExists('psychologists');
    }
};
