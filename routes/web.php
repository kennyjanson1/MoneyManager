<?php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MoneyController;
use Illuminate\Support\Facades\Route;   

// The root route is MOVED and will now be the first route inside the 
// authenticated group to ensure the user is logged in before accessing it.

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('transactions', TransactionController::class);

    // Route ke MoneyController
    Route::get('/money', [MoneyController::class, 'index'])->name('money.index');
});


// A route for guests (unauthenticated users) can be added here if needed, 
// for example, to show a marketing page or simply redirect to login.
// Since we require auth for '/', unauthenticated users will be redirected to the login page by Laravel.

require __DIR__.'/auth.php';
