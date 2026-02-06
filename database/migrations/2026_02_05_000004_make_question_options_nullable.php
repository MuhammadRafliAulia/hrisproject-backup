<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw SQL to alter columns so this does not require doctrine/dbal
        DB::statement(<<<'SQL'
            ALTER TABLE `questions`
            MODIFY `option_a` TEXT NULL,
            MODIFY `option_b` TEXT NULL,
            MODIFY `option_c` TEXT NULL,
            MODIFY `option_d` TEXT NULL,
            MODIFY `correct_answer` CHAR(1) NULL;
        SQL
        );
    }

    public function down(): void
    {
        // Revert to NOT NULL with empty defaults where possible
        DB::statement(<<<'SQL'
            ALTER TABLE `questions`
            MODIFY `option_a` TEXT NOT NULL,
            MODIFY `option_b` TEXT NOT NULL,
            MODIFY `option_c` TEXT NOT NULL,
            MODIFY `option_d` TEXT NOT NULL,
            MODIFY `correct_answer` CHAR(1) NOT NULL;
        SQL
        );
    }
};
