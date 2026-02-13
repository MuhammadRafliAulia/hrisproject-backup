<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warning_letters', function (Blueprint $table) {
            // Add NIK and paragraf kedua
            $table->string('nik')->nullable()->after('nama');
            $table->text('paragraf_kedua')->nullable()->after('alasan');

            // 5 signers: name + jabatan + signature image
            // Signer 1 = Pimpinan Kerja (main)
            $table->string('signer_name_1')->nullable();
            $table->string('signer_jabatan_1')->nullable();
            $table->longText('signature_1')->nullable();

            // Signer 2 = Atasan / Manager (main)
            $table->string('signer_name_2')->nullable();
            $table->string('signer_jabatan_2')->nullable();
            $table->longText('signature_2')->nullable();

            // Signer 3 = Saksi 1
            $table->string('signer_name_3')->nullable();
            $table->string('signer_jabatan_3')->nullable();
            $table->longText('signature_3')->nullable();

            // Signer 4 = Saksi 2
            $table->string('signer_name_4')->nullable();
            $table->string('signer_jabatan_4')->nullable();
            $table->longText('signature_4')->nullable();

            // Signer 5 = HR
            $table->string('signer_name_5')->nullable();
            $table->string('signer_jabatan_5')->nullable();
            $table->longText('signature_5')->nullable();
        });

        // Migrate old data to new columns
        DB::statement("UPDATE warning_letters SET signer_name_5 = signer_hrd_name, signature_5 = signature_hrd, signer_jabatan_5 = 'HRD Manager' WHERE signer_hrd_name IS NOT NULL");
        DB::statement("UPDATE warning_letters SET signer_name_1 = signer_dept_head_name, signature_1 = signature_dept_head, signer_jabatan_1 = 'Kepala Departemen' WHERE signer_dept_head_name IS NOT NULL");

        // Drop old columns
        Schema::table('warning_letters', function (Blueprint $table) {
            $table->dropColumn(['signature_hrd', 'signer_hrd_name', 'signature_dept_head', 'signer_dept_head_name']);
        });
    }

    public function down(): void
    {
        Schema::table('warning_letters', function (Blueprint $table) {
            $table->longText('signature_hrd')->nullable();
            $table->string('signer_hrd_name')->nullable();
            $table->longText('signature_dept_head')->nullable();
            $table->string('signer_dept_head_name')->nullable();
        });

        DB::statement("UPDATE warning_letters SET signer_hrd_name = signer_name_5, signature_hrd = signature_5 WHERE signer_name_5 IS NOT NULL");
        DB::statement("UPDATE warning_letters SET signer_dept_head_name = signer_name_1, signature_dept_head = signature_1 WHERE signer_name_1 IS NOT NULL");

        Schema::table('warning_letters', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'paragraf_kedua',
                'signer_name_1', 'signer_jabatan_1', 'signature_1',
                'signer_name_2', 'signer_jabatan_2', 'signature_2',
                'signer_name_3', 'signer_jabatan_3', 'signature_3',
                'signer_name_4', 'signer_jabatan_4', 'signature_4',
                'signer_name_5', 'signer_jabatan_5', 'signature_5',
            ]);
        });
    }
};
