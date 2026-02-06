<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept', 'name');
    }

    protected $fillable = [
        'user_id', 'nik', 'nama', 'gol', 'dept', 'jabatan', 'seksi', 'tempat_lahir', 'tgl_lahir', 'gol_darah',
        'alamat_domisili', 'status_tempat_tinggal', 'no_telpon', 'no_wa', 'kontak_darurat', 'tgl_masuk',
        'bulan_masuk', 'tahun_masuk', 'status_karyawan', 'status_pph', 'end_pkwt_1', 'end_pkwt_2',
        'tgl_pengangkatan', 'tgl_sekarang', 'masa_kerja', 'usia', 'npwp', 'jamsostek', 'no_kpj_bpjstk',
        'no_kk', 'ktp', 'alamat_email', 'status_perkawinan', 'status_perkawinan_excel', 'pendidikan',
        'asal_sekolah', 'ar', 'end', 'bulan_end', 'status_aktif', 'alamat_npwp', 'alamat_asal', 'agama',
        'asal_kota', 'alamat_domisili_kecamatan', 'area_asal_kecamatan', 'area_asal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }
}
