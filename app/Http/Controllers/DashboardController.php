<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get employees by dept (departemen)
        $employeesByDept = Employee::where('user_id', Auth::id())
            ->selectRaw('dept, COUNT(*) as count')
            ->groupBy('dept')
            ->pluck('count', 'dept');

        // Get employees by status
        $employeesByStatus = Employee::where('user_id', Auth::id())
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Prepare chart data
        $deptLabels = $employeesByDept->keys()->toArray();
        $deptData = $employeesByDept->values()->toArray();

        $statusLabels = $employeesByStatus->keys()->toArray();
        $statusData = $employeesByStatus->values()->toArray();

        $totalEmployees = Employee::where('user_id', Auth::id())->count();

        return view('dashboard', compact('deptLabels', 'deptData', 'statusLabels', 'statusData', 'totalEmployees'));
    }
}
