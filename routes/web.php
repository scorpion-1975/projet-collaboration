<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('pages.index');
})->name('panel');


// Route pour afficher le formulaire d'inscription
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Route pour traiter l'inscription
Route::post('/register', [AuthController::class, 'register']);


// Route pour afficher le formulaire de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route pour traiter la connexion
Route::post('/login', [AuthController::class, 'login']);

// Route pour traiter la connexion
Route::get('/users-profile', [AuthController::class, 'profile'])->name('profile');

// Routes d'authentification
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('/login', function () {
//     return view('pages.pages-login');
// })->name('login');

// Route::get('/register', function () {
//     return view('pages.pages-register');
// })->name('register');
