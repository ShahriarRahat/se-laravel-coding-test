<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Show Transaction & current balance if logged in
Route::get('/',                 [TransactionController::class, 'index'])->name('home');

// Registration Routes
Route::get('/register',         [UserController::class, 'register'])->name('register');
Route::post('/users',           [UserController::class, 'store'])->name('registerUser');

// Login Routes
Route::get('/login',            [UserController::class, 'index'])->name('login');
Route::post('/login',           [UserController::class, 'login'])->name('loginUser');
Route::get('/logout',           [UserController::class, 'logout'])->name('logout');

// Must Need Authentication Routes - Deposits & Withdrawals
Route::group(['middleware' => ['auth']], function () {
    Route::get('/deposit',      [TransactionController::class, 'deposits'])->name('deposit');
    Route::post('/deposit',     [TransactionController::class, 'deposit'])->name('deposit.store');
    
    Route::get('/withdrawal',   [TransactionController::class, 'withdrawals'])->name('withdrawal');
    Route::post('/withdrawal',  [TransactionController::class, 'withdrawal'])->name('withdrawal.store');
});

