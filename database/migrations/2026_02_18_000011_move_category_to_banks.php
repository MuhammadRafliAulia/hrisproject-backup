<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add category to banks if it doesn't exist
        if (!Schema::hasColumn('banks', 'category')) {
            Schema::table('banks', function (Blueprint $table) {
                $table->string('category')->default('calon_karyawan')->after('description');
            });
        }

        // Remove category from questions if exists
        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('category')->default('calon_karyawan')->after('type');
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
