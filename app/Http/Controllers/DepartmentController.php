<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);
        Department::create($validated);
        ActivityLog::log('create', 'department', 'Menambahkan departemen: ' . $validated['name']);
        return redirect()->route('departments.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);
        $department->update($validated);
        ActivityLog::log('update', 'department', 'Mengupdate departemen: ' . $validated['name']);
        return redirect()->route('departments.index')->with('success', 'Departemen berhasil diupdate.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        ActivityLog::log('delete', 'department', 'Menghapus departemen: ' . $department->name);
        return redirect()->route('departments.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
