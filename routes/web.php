<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Authenticated routes for managing question banks
Route::middleware('auth')->group(function () {
    Route::resource('banks', BankController::class);
    Route::get('/banks/{bank}/results', [BankController::class, 'results'])->name('banks.results');
    Route::post('/banks/{bank}/generate-link', [BankController::class, 'generateLink'])->name('banks.generate-link');
    Route::post('/banks/{bank}/toggle', [BankController::class, 'toggleBank'])->name('banks.toggle');
    Route::get('/questions/{question}/edit', [BankController::class, 'editQuestion'])->name('questions.edit');
    Route::put('/questions/{question}', [BankController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('/questions/{question}', [BankController::class, 'deleteQuestion'])->name('questions.delete');
    Route::get('/banks/{bank}/export', [BankController::class, 'exportResults'])->name('banks.export');
    Route::get('/banks/{bank}/export-excel', [BankController::class, 'exportExcel'])->name('banks.export-excel');
});

// Authenticated routes for managing employees
Route::middleware('auth')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::get('/employees-import', [EmployeeController::class, 'showImport'])->name('employees.import-form');
    Route::post('/employees-import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::get('/employees-template', [EmployeeController::class, 'downloadTemplate'])->name('employees.template');
    Route::get('/employees-export', [EmployeeController::class, 'exportExcel'])->name('employees.export');
});

// Public test routes
Route::get('/test/{token}', [TestController::class, 'show'])->name('test.show');
Route::post('/test/{token}/form', [TestController::class, 'submitForm'])->name('test.submit-form');
Route::post('/test/{token}/submit', [TestController::class, 'submit'])->name('test.submit');
Route::get('/test/{token}/result', [TestController::class, 'result'])->name('test.result');

// Serve storage files in development if storage:link is not available
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (file_exists($file)) {
        return response()->file($file);
    }
    abort(404);
})->where('path', '.*')->name('storage.serve');


