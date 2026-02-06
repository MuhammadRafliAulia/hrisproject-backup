<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('description');
        });

        // Drop is_active dari participant_responses jika ada
        if (Schema::hasColumn('participant_responses', 'is_active')) {
            Schema::table('participant_responses', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }

    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('participant_responses', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('token');
        });
    }
};
