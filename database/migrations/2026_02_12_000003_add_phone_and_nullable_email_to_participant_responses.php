<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneAndNullableEmailToParticipantResponses extends Migration
{
    public function up()
    {
        // Make participant_email nullable using raw SQL (no doctrine/dbal needed)
        \DB::statement('ALTER TABLE `participant_responses` MODIFY `participant_email` VARCHAR(255) NULL DEFAULT NULL');

        Schema::table('participant_responses', function (Blueprint $table) {
            // Add phone column
            $table->string('phone', 20)->nullable()->after('participant_email');
        });
    }

    public function down()
    {
        \DB::statement('ALTER TABLE `participant_responses` MODIFY `participant_email` VARCHAR(255) NOT NULL');

        Schema::table('participant_responses', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
}
