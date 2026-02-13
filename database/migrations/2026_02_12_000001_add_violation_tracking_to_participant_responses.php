<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participant_responses', function (Blueprint $table) {
            $table->integer('violation_count')->default(0)->after('completed_at');
            $table->json('violation_log')->nullable()->after('violation_count');
            $table->string('anti_cheat_note')->nullable()->after('violation_log');
        });
    }

    public function down(): void
    {
        Schema::table('participant_responses', function (Blueprint $table) {
            $table->dropColumn(['violation_count', 'violation_log', 'anti_cheat_note']);
        });
    }
};
