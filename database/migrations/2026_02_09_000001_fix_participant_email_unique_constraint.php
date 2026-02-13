<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixParticipantEmailUniqueConstraint extends Migration
{
    public function up()
    {
        Schema::table('participant_responses', function (Blueprint $table) {
            // Drop the global unique on email
            $table->dropUnique(['participant_email']);

            // Add composite unique: same email can take different tests, but not the same test twice
            $table->unique(['bank_id', 'participant_email'], 'participant_responses_bank_email_unique');
        });
    }

    public function down()
    {
        Schema::table('participant_responses', function (Blueprint $table) {
            $table->dropUnique('participant_responses_bank_email_unique');
            $table->unique('participant_email');
        });
    }
}
