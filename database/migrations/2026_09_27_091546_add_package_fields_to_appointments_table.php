<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->smallInteger('source_type')
                ->default(1)
                ->after('service_rate_id');

            $table->foreignId('patient_package_id')
                ->nullable()
                ->after('source_type')
                ->constrained('patient_packages')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('service_package_detail_id')
                ->nullable()
                ->after('patient_package_id')
                ->constrained('service_package_details')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->index(
                ['source_type', 'patient_package_id'],
                'appointments_source_package_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->dropForeign([
                'patient_package_id'
            ]);

            $table->dropForeign([
                'service_package_detail_id'
            ]);

            $table->dropIndex(
                'appointments_source_package_idx'
            );

            $table->dropColumn([
                'source_type',
                'patient_package_id',
                'service_package_detail_id',
            ]);
        });
    }
};