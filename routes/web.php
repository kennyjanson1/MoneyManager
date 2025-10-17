<?php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;   

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('transactions', TransactionController::class);

    // Route ke MoneyController
    Route::get('/money', [MoneyController::class, 'index'])->name('money.index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// A route for guests (unauthenticated users) can be added here if needed, 
// for example, to show a marketing page or simply redirect to login.
// Since we require auth for '/', unauthenticated users will be redirected to the login page by Laravel.

require __DIR__.'/auth.php';
