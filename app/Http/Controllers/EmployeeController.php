<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'status' => 'required|in:kontrak,tetap',
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
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'status' => 'required|in:kontrak,tetap',
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
        $csv = "nama,jabatan,status\n";
        $csv .= "Budi Santoso,Manager,tetap\n";
        $csv .= "Siti Nurhaliza,Staff,kontrak\n";

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="template_karyawan.csv"');
    }

    public function exportExcel()
    {
        $employees = Employee::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        
        // Create CSV with proper headers
        $csv = "Nama,Jabatan,Status\n";
        
        foreach ($employees as $employee) {
            // Escape CSV values
            $nama = '"' . str_replace('"', '""', $employee->nama) . '"';
            $jabatan = '"' . str_replace('"', '""', $employee->jabatan) . '"';
            $status = ucfirst($employee->status);
            
            $csv .= "{$nama},{$jabatan},{$status}\n";
        }
        
        $fileName = 'karyawan_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        // Return as Excel/CSV downloadable file
        return response($csv)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
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
