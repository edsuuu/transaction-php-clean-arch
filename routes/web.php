<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rota pública - redireciona para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de autenticação (guest)
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/cadastro', 'auth.register')->name('register');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Rotas protegidas (autenticadas)
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'app.dashboard')->name('dashboard');
    Route::view('/depositar', 'app.deposit')->name('deposit');
    Route::view('/transferir', 'app.transfer')->name('transfer');
    Route::view('/extrato', 'app.history')->name('history');
});
