<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddOptionImagesToQuestionsTable extends Migration
{
    public function up()
    {
        \DB::statement("ALTER TABLE `questions`
            ADD COLUMN `option_a_image` VARCHAR(255) NULL DEFAULT NULL AFTER `option_a`,
            ADD COLUMN `option_b_image` VARCHAR(255) NULL DEFAULT NULL AFTER `option_b`,
            ADD COLUMN `option_c_image` VARCHAR(255) NULL DEFAULT NULL AFTER `option_c`,
            ADD COLUMN `option_d_image` VARCHAR(255) NULL DEFAULT NULL AFTER `option_d`
        ");
    }

    public function down()
    {
        \DB::statement("ALTER TABLE `questions`
            DROP COLUMN `option_a_image`,
            DROP COLUMN `option_b_image`,
            DROP COLUMN `option_c_image`,
            DROP COLUMN `option_d_image`
        ");
    }
}
