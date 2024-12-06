<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PrescriptionController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('user:sanctum');

Route::middleware('user:sanctum') -> group (function() {
    Route::get('/users/{id}', [UserController::class, 'index']);
});

Route::get('/user', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Patient Routes (CRUD operations for patients)
// Remove the redundant individual routes and keep the resource route
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('patients', PatientController::class);
});

// Medicine Routes (CRUD operations for medicines)
Route::middleware('user:sanctum')->group(function () {
    Route::resource('medicines', MedicineController::class);
});

// Prescription Routes (CRUD operations for prescriptions)
Route::get('prescriptions', [PrescriptionController::class, 'index']); // Get all prescriptions
Route::get('prescriptions/{id}', [PrescriptionController::class, 'show']); // Get a specific prescription

Route::middleware('user:sanctum')->group(function () {
    Route::post('prescriptions', [PrescriptionController::class, 'store']);
    Route::put('prescriptions/{id}', [PrescriptionController::class, 'update']);
    Route::delete('prescriptions/{id}', [PrescriptionController::class, 'destroy']);
});

Route::middleware('user:sanctum')->group(function () {
    Route::resource('patients', PatientController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('prescriptions', PrescriptionController::class);
});
