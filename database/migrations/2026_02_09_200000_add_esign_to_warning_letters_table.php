<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEsignToWarningLettersTable extends Migration
{
    public function up()
    {
        Schema::table('warning_letters', function (Blueprint $table) {
            $table->string('status', 30)->default('pending')->after('tanggal_surat');
            $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->longText('signature_hrd')->nullable()->after('approved_at');
            $table->string('signer_hrd_name')->nullable()->after('signature_hrd');
            $table->longText('signature_dept_head')->nullable()->after('signer_hrd_name');
            $table->string('signer_dept_head_name')->nullable()->after('signature_dept_head');

            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('warning_letters', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'status', 'approved_by', 'approved_at',
                'signature_hrd', 'signer_hrd_name',
                'signature_dept_head', 'signer_dept_head_name',
            ]);
        });
    }
}
