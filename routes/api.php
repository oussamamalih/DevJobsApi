<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OffreController;
use App\Http\Controllers\Api\EntrepriseController;
use App\Http\Controllers\Api\CompetenceController;


// Test authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Authentication
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');


// Offres (job listings)
Route::get('/offres', [OffreController::class, 'index']);
Route::get('/offres/{offre}', [OffreController::class, 'show']);

Route::middleware(['auth:sanctum', 'role:company,admin'])->group(function () {
    Route::post('/offres', [OffreController::class, 'store']);
    Route::put('/offres/{offre}', [OffreController::class, 'update']);
    Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);
});


// Entreprises (companies)
Route::get('/entreprises', [EntrepriseController::class, 'index']);
Route::get('/entreprises/{entreprise}', [EntrepriseController::class, 'show']);

Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
    Route::post('/entreprises', [EntrepriseController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'role:company,admin'])->group(function () {
    Route::put('/entreprises/{entreprise}', [EntrepriseController::class, 'update']);
    Route::delete('/entreprises/{entreprise}', [EntrepriseController::class, 'destroy']);
});


// Competences (skills) - read is public, write is admin only
Route::get('/competences', [CompetenceController::class, 'index']);
Route::get('/competences/{competence}', [CompetenceController::class, 'show']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/competences', [CompetenceController::class, 'store']);
    Route::put('/competences/{competence}', [CompetenceController::class, 'update']);
    Route::delete('/competences/{competence}', [CompetenceController::class, 'destroy']);
});