<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToBanksTable extends Migration
{
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->unsignedInteger('duration_minutes')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('duration_minutes');
        });
    }
}
