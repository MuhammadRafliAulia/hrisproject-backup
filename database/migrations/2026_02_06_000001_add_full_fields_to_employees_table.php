<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('nik')->nullable();
            $table->string('gol')->nullable();
            $table->string('dept')->nullable();
            $table->string('seksi')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('gol_darah')->nullable();
            $table->string('alamat_domisili')->nullable();
            $table->string('status_tempat_tinggal')->nullable();
            $table->string('no_telpon')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('kontak_darurat')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->string('bulan_masuk')->nullable();
            $table->string('tahun_masuk')->nullable();
            $table->string('status_karyawan')->nullable();
            $table->string('status_pph')->nullable();
            $table->date('end_pkwt_1')->nullable();
            $table->date('end_pkwt_2')->nullable();
            $table->date('tgl_pengangkatan')->nullable();
            $table->date('tgl_sekarang')->nullable();
            $table->string('masa_kerja')->nullable();
            $table->string('usia')->nullable();
            $table->string('npwp')->nullable();
            $table->string('jamsostek')->nullable();
            $table->string('no_kpj_bpjstk')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('ktp')->nullable();
            $table->string('alamat_email')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('status_perkawinan_excel')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('ar')->nullable();
            $table->date('end')->nullable();
            $table->string('bulan_end')->nullable();
            $table->string('status_aktif')->nullable();
            $table->string('alamat_npwp')->nullable();
            $table->string('alamat_asal')->nullable();
            $table->string('agama')->nullable();
            $table->string('asal_kota')->nullable();
            $table->string('alamat_domisili_kecamatan')->nullable();
            $table->string('area_asal_kecamatan')->nullable();
            $table->string('area_asal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'nik','gol','dept','seksi','tempat_lahir','tgl_lahir','gol_darah','alamat_domisili','status_tempat_tinggal','no_telpon','no_wa','kontak_darurat','tgl_masuk','bulan_masuk','tahun_masuk','status_karyawan','status_pph','end_pkwt_1','end_pkwt_2','tgl_pengangkatan','tgl_sekarang','masa_kerja','usia','npwp','jamsostek','no_kpj_bpjstk','no_kk','ktp','alamat_email','status_perkawinan','status_perkawinan_excel','pendidikan','asal_sekolah','ar','end','bulan_end','status_aktif','alamat_npwp','alamat_asal','agama','asal_kota','alamat_domisili_kecamatan','area_asal_kecamatan','area_asal'
            ]);
        });
    }
};
