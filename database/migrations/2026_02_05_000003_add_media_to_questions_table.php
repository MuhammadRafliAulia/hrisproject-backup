<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('type')->default('multiple_choice'); // multiple_choice or text
            $table->string('image')->nullable(); // path to image
            $table->string('audio')->nullable(); // path to audio
            $table->text('correct_answer_text')->nullable(); // for text type
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['type', 'image', 'audio', 'correct_answer_text']);
        });
    }
};
