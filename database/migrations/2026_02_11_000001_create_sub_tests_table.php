<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();
        });

        // Add sub_test_id and is_example to questions
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('sub_test_id')->nullable()->after('bank_id')->constrained('sub_tests')->onDelete('cascade');
            $table->boolean('is_example')->default(false)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['sub_test_id']);
            $table->dropColumn(['sub_test_id', 'is_example']);
        });
        Schema::dropIfExists('sub_tests');
    }
};
