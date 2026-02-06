<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $families = $employee->families;
        return view('families.index', compact('employee', 'families'));
    }
}
