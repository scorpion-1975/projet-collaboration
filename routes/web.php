<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;


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



Route::middleware(['auth'])->group(function () {

    // Afficher les projets de l'utilisateur
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    // Créer un projet
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');

    // Afficher un projet spécifique
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // Inviter un utilisateur dans un projet
    Route::get('/projects/{project}/invite', [ProjectController::class, 'showInviteForm'])->name('projects.invite');
    Route::post('/projects/{project}/invite', [ProjectController::class, 'inviteUser'])->name('projects.invite.store');


    // Modifier le statut du projet
    Route::post('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');



    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');

});


// Route::get('/login', function () {
//     return view('pages.pages-login');
// })->name('login');

// Route::get('/register', function () {
//     return view('pages.pages-register');
// })->name('register');
