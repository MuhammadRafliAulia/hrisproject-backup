<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarningLettersTable extends Migration
{
    public function up()
    {
        Schema::create('warning_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('departemen');
            $table->text('alasan');
            $table->tinyInteger('sp_level')->comment('1=SP1, 2=SP2, 3=SP3');
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('warning_letters');
    }
}
