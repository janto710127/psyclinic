<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedInteger('duration')
                ->default(60)
                ->after('appointment_time');
        });

        /*
        |--------------------------------------------------------------------------
        | Isi duration untuk appointment lama
        |--------------------------------------------------------------------------
        */

        DB::statement('
            UPDATE appointments a
            INNER JOIN service_rates sr
                ON sr.id = a.service_rate_id
            SET a.duration = sr.duration
        ');
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};