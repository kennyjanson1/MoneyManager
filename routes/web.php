<?php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// The root route is MOVED and will now be the first route inside the 
// authenticated group to ensure the user is logged in before accessing it.

Route::middleware(['auth', 'verified'])->group(function () {
    // 1. Set the root path to use the DashboardController index method.
    // This will redirect unauthenticated users to the login screen.
    Route::get('/', [DashboardController::class, 'index']);

    // 2. The /dashboard route can now be removed as it duplicates the root path logic.
    // However, keeping it with a name is often useful for redirects.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('transactions', TransactionController::class);
});

// A route for guests (unauthenticated users) can be added here if needed, 
// for example, to show a marketing page or simply redirect to login.
// Since we require auth for '/', unauthenticated users will be redirected to the login page by Laravel.

require __DIR__.'/auth.php';
