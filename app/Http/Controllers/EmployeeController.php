<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    // ...existing code...

    public function show(Employee $employee)
    {
        if ($employee->user_id !== Auth::id()) {
            abort(403);
        }
        return view('employees.show', compact('employee'));
    }
    public function index(Request $request)
    {
        $query = Employee::where('user_id', Auth::id());
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('nama', 'like', "%$q%")
                    ->orWhere('nik', 'like', "%$q%") ;
            });
        }
        if ($request->filled('dept')) {
            $query->where('dept', $request->dept);
        }
        $employees = $query->orderBy('created_at', 'desc')->get();
        $departments = \App\Models\Department::orderBy('name')->get();
        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'gol' => 'nullable|string|max:255',
            'dept' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'seksi' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'gol_darah' => 'nullable|string|max:10',
            'alamat_domisili' => 'nullable|string|max:255',
            'status_tempat_tinggal' => 'nullable|string|max:255',
            'no_telpon' => 'nullable|string|max:255',
            'no_wa' => 'nullable|string|max:255',
            'kontak_darurat' => 'nullable|string|max:255',
            'tgl_masuk' => 'nullable|date',
            'bulan_masuk' => 'nullable|string|max:20',
            'tahun_masuk' => 'nullable|string|max:10',
            'status_karyawan' => 'nullable|string|max:50',
            'status_pph' => 'nullable|string|max:50',
            'end_pkwt_1' => 'nullable|date',
            'end_pkwt_2' => 'nullable|date',
            'tgl_pengangkatan' => 'nullable|date',
            'tgl_sekarang' => 'nullable|date',
            'masa_kerja' => 'nullable|string|max:100',
            'usia' => 'nullable|string|max:10',
            'npwp' => 'nullable|string|max:50',
            'jamsostek' => 'nullable|string|max:50',
            'no_kpj_bpjstk' => 'nullable|string|max:50',
            'no_kk' => 'nullable|string|max:50',
            'ktp' => 'nullable|string|max:50',
            'alamat_email' => 'nullable|email|max:255',
            'status_perkawinan' => 'nullable|string|max:50',
            'status_perkawinan_excel' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:50',
            'asal_sekolah' => 'nullable|string|max:100',
            'ar' => 'nullable|string|max:50',
            'end' => 'nullable|date',
            'bulan_end' => 'nullable|string|max:20',
            'status_aktif' => 'nullable|string|max:20',
            'alamat_npwp' => 'nullable|string|max:255',
            'alamat_asal' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:50',
            'asal_kota' => 'nullable|string|max:100',
            'alamat_domisili_kecamatan' => 'nullable|string|max:100',
            'area_asal_kecamatan' => 'nullable|string|max:100',
            'area_asal' => 'nullable|string|max:100',
        ]);

        Employee::create(array_merge($validated, ['user_id' => Auth::id()]));
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        if ($employee->user_id !== Auth::id()) {
            abort(403);
        }
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        if ($employee->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nik' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'gol' => 'nullable|string|max:255',
            'dept' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'seksi' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'gol_darah' => 'nullable|string|max:10',
            'alamat_domisili' => 'nullable|string|max:255',
            'status_tempat_tinggal' => 'nullable|string|max:255',
            'no_telpon' => 'nullable|string|max:255',
            'no_wa' => 'nullable|string|max:255',
            'kontak_darurat' => 'nullable|string|max:255',
            'tgl_masuk' => 'nullable|date',
            'bulan_masuk' => 'nullable|string|max:20',
            'tahun_masuk' => 'nullable|string|max:10',
            'status_karyawan' => 'nullable|string|max:50',
            'status_pph' => 'nullable|string|max:50',
            'end_pkwt_1' => 'nullable|date',
            'end_pkwt_2' => 'nullable|date',
            'tgl_pengangkatan' => 'nullable|date',
            'tgl_sekarang' => 'nullable|date',
            'masa_kerja' => 'nullable|string|max:100',
            'usia' => 'nullable|string|max:10',
            'npwp' => 'nullable|string|max:50',
            'jamsostek' => 'nullable|string|max:50',
            'no_kpj_bpjstk' => 'nullable|string|max:50',
            'no_kk' => 'nullable|string|max:50',
            'ktp' => 'nullable|string|max:50',
            'alamat_email' => 'nullable|email|max:255',
            'status_perkawinan' => 'nullable|string|max:50',
            'status_perkawinan_excel' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:50',
            'asal_sekolah' => 'nullable|string|max:100',
            'ar' => 'nullable|string|max:50',
            'end' => 'nullable|date',
            'bulan_end' => 'nullable|string|max:20',
            'status_aktif' => 'nullable|string|max:20',
            'alamat_npwp' => 'nullable|string|max:255',
            'alamat_asal' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:50',
            'asal_kota' => 'nullable|string|max:100',
            'alamat_domisili_kecamatan' => 'nullable|string|max:100',
            'area_asal_kecamatan' => 'nullable|string|max:100',
            'area_asal' => 'nullable|string|max:100',
        ]);

        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user_id !== Auth::id()) {
            abort(403);
        }

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function showImport()
    {
        return view('employees.import');
    }


    public function downloadTemplate()
    {
        $headers = [
            'NIK', 'NAMA', 'GOL', 'DEPT', 'JABATAN', 'SEKSI', 'TEMPAT LAHIR', 'TGL. LAHIR', 'GOL. DARAH',
            'ALAMAT DOMISILI', 'STATUS TEMPAT TINGGAL', 'NO TELPON', 'NO. WA', 'PIHAK YANG DAPAT DIHUBUNGI SAAT DARURAT',
            'TGL. MASUK', 'BULAN MASUK', 'TAHUN MASUK', 'STATUS', 'STATUS PPH', 'END PKWT 1', 'END PKWT 2',
            'TGL. PENGANGKATAN', 'TGL SEKARANG', 'MASA KERJA DIA', 'USIA', 'NPWP', 'JAMSOSTEK', 'NO KPJ BPJSTK',
            'NO.KK', 'KTP', 'ALAMAT EMAIL', 'STATUS PERKAWINAN', 'STATUS PERKAWINAN (EXCEL)', 'PENDIDIKAN',
            'ASAL SEKOLAH', 'A.R.', 'END', 'BULAN END', 'STATUS (AKTIF/TIDAK AKTIF)', 'ALAMAT NPWP', 'ALAMAT ASAL',
            'AGAMA', 'ASAL KOTA', 'ALAMAT DOMISILI KECAMATAN', 'AREA ASAL KECAMATAN', 'AREA ASAL'
        ];
        $csv = implode(',', $headers) . "\n";
        $csv .= "12345678,Budi Santoso,III,HRD,Manager,SDM,Jakarta,1980-01-01,O,Jakarta Selatan,Milik Sendiri,08123456789,08123456789,Ibu Budi,2000-01-01,01,2000,tetap,PTKP,2022-01-01,2023-01-01,2021-01-01,2026-02-06,22 TAHUN 5 BULAN 1 HARI,45,1234567890,1234567890,1234567890,1234567890,1234567890,budi@email.com,Kawin,Kawin,S1,UI,AR1,2025-12-31,12,AKTIF,Alamat NPWP,Alamat Asal,Islam,Jakarta,Setiabudi,Setiabudi,Jakarta\n";
        $csv .= "87654321,Siti Nurhaliza,II,Finance,Staff,Accounting,Bandung,1990-02-02,A,Bandung,Kos,08234567890,08234567890,Bapak Siti,2010-02-02,02,2010,kontrak,PTKP,2023-02-02,2024-02-02,2022-02-02,2026-02-06,16 TAHUN 0 BULAN 4 HARI,36,0987654321,0987654321,0987654321,0987654321,0987654321,siti@email.com,Belum Kawin,Belum Kawin,S2,ITB,AR2,2026-12-31,12,AKTIF,Alamat NPWP 2,Alamat Asal 2,Kristen,Bandung,Antapani,Antapani,Bandung\n";
        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="template_karyawan.csv"');
    }

    public function exportExcel()
    {
        $headers = [
            'NIK', 'NAMA', 'GOL', 'DEPT', 'JABATAN', 'SEKSI', 'TEMPAT LAHIR', 'TGL. LAHIR', 'GOL. DARAH',
            'ALAMAT DOMISILI', 'STATUS TEMPAT TINGGAL', 'NO TELPON', 'NO. WA', 'PIHAK YANG DAPAT DIHUBUNGI SAAT DARURAT',
            'TGL. MASUK', 'BULAN MASUK', 'TAHUN MASUK', 'STATUS', 'STATUS PPH', 'END PKWT 1', 'END PKWT 2',
            'TGL. PENGANGKATAN', 'TGL SEKARANG', 'MASA KERJA DIA', 'USIA', 'NPWP', 'JAMSOSTEK', 'NO KPJ BPJSTK',
            'NO.KK', 'KTP', 'ALAMAT EMAIL', 'STATUS PERKAWINAN', 'STATUS PERKAWINAN (EXCEL)', 'PENDIDIKAN',
            'ASAL SEKOLAH', 'A.R.', 'END', 'BULAN END', 'STATUS (AKTIF/TIDAK AKTIF)', 'ALAMAT NPWP', 'ALAMAT ASAL',
            'AGAMA', 'ASAL KOTA', 'ALAMAT DOMISILI KECAMATAN', 'AREA ASAL KECAMATAN', 'AREA ASAL'
        ];
        $csv = implode(',', $headers) . "\n";
        $employees = Employee::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        foreach ($employees as $employee) {
            $row = [
                $employee->nik, $employee->nama, $employee->gol, $employee->dept, $employee->jabatan, $employee->seksi, $employee->tempat_lahir, $employee->tgl_lahir, $employee->gol_darah,
                $employee->alamat_domisili, $employee->status_tempat_tinggal, $employee->no_telpon, $employee->no_wa, $employee->kontak_darurat, $employee->tgl_masuk, $employee->bulan_masuk, $employee->tahun_masuk,
                $employee->status_karyawan, $employee->status_pph, $employee->end_pkwt_1, $employee->end_pkwt_2, $employee->tgl_pengangkatan, $employee->tgl_sekarang, $employee->masa_kerja, $employee->usia,
                $employee->npwp, $employee->jamsostek, $employee->no_kpj_bpjstk, $employee->no_kk, $employee->ktp, $employee->alamat_email, $employee->status_perkawinan, $employee->status_perkawinan_excel,
                $employee->pendidikan, $employee->asal_sekolah, $employee->ar, $employee->end, $employee->bulan_end, $employee->status_aktif, $employee->alamat_npwp, $employee->alamat_asal, $employee->agama,
                $employee->asal_kota, $employee->alamat_domisili_kecamatan, $employee->area_asal_kecamatan, $employee->area_asal
            ];
            $csv .= implode(',', array_map(function($v) {
                return '"' . str_replace('"', '""', $v) . '"';
            }, $row)) . "\n";
        }
        $fileName = 'karyawan_' . date('Y-m-d_H-i-s') . '.csv';
        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());
        $lines = explode("\n", $content);

        $imported = 0;
        $errors = [];

        // Skip header
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) continue;

            $data = str_getcsv($line);

            if (count($data) < 3) {
                $errors[] = "Baris " . ($i + 1) . ": Data tidak lengkap";
                continue;
            }

            $nama = trim($data[0]);
            $jabatan = trim($data[1]);
            $status = strtolower(trim($data[2]));

            if (empty($nama) || empty($jabatan) || empty($status)) {
                $errors[] = "Baris " . ($i + 1) . ": Beberapa kolom kosong";
                continue;
            }

            if (!in_array($status, ['kontrak', 'tetap'])) {
                $errors[] = "Baris " . ($i + 1) . ": Status harus 'kontrak' atau 'tetap'";
                continue;
            }

            try {
                Employee::create([
                    'user_id' => Auth::id(),
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'status' => $status,
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
            }
        }

        $message = "$imported karyawan berhasil diimport.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " baris error: " . implode(" | ", array_slice($errors, 0, 3));
        }

        return redirect()->route('employees.index')->with('success', $message);
    }
}
