<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/employees/{employee}/families', [App\Http\Controllers\FamilyController::class, 'index'])->name('families.index');
});
