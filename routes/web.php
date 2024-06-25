<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return view('login');
});

//Restricted Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard');
    // Rooms
    Route::get('room/{roomId}', [RoomController::class, 'roomView'])->where('roomId', '[0-9]+');
    
    //Messages:
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages/{roomId}', 'messageGet')->name('messageGet')->where('roomId', '[0-9]+');
        Route::post('/messages', 'messageSend')->name('messageSend');
    });

    Route::get('/signout', [AuthController::class, 'signOut'])->name('signout');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginView')->name('login');
    Route::post('/login','userLogin')->name('userLogin');
    
    Route::get('/register', 'registrationView')->name('register');
    Route::post('/register', 'userRegister')->name('userRegister');    
});

