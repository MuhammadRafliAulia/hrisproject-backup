<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->string('participant_name');
            $table->string('participant_email')->unique();
            $table->string('token')->unique();
            $table->json('responses')->nullable(); // {question_id: answer, ...}
            $table->integer('score')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_responses');
    }
};
