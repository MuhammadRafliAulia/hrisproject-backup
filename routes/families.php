<?php

use Illuminate\Support\Facades\Route;

Route::get('/employees/{employee}/families', [App\Http\Controllers\FamilyController::class, 'index'])->name('families.index');
