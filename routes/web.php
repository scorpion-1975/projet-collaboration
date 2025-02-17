<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
});
Route::get('/login', function () {
    return view('pages.pages-login');
})->name('login');

Route::get('/register', function () {
    return view('pages.pages-register');
})->name('register');
