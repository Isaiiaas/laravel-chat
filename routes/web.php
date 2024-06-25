<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

//Restricted Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardView']);
    // Rooms
    // Route::get('rooms', [RoomsController::class, 'dashboard']);
    // Route::put('rooms', [RoomsController::class, 'dashboard']);
    // Messages: 
    // Route::get('/messages/{roomId}', [RoomsController::class, 'dashboard'])->whereUuid('id');
    // Route::put('/messages', [RoomsController::class, 'dashboard']); 
});

// Route::middleware(['auth','adminAuth'])->group(function () {
    // Route::get('room/new', [RoomsController::class, 'dashboard']); 
    // Route::get('user/list', [DashboardController::class, 'dashboard']); 
    // Route::poast('user/edit', [DashboardController::class, 'dashboard']); 
// });

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginView')->name('login');
    Route::post('/login','userLogin')->name('userLogin');
    
    Route::get('/register', 'registrationView')->name('register-user');
    Route::post('/register', 'userRegister')->name('userRegister');
    
    Route::get('/signout', 'signOut')->name('signout');
});

