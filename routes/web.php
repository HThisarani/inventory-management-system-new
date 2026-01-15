<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Redirect Root to Login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | Inventory
    */
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

    Route::get('/inventory/add', function () {
        return Inertia::render('Inventory/Add', [
            'existingItems' => \App\Models\Item::select('name')->distinct()->get(),
        ]);
    })->name('inventory.add');

    Route::post('/inventory/add', [InventoryController::class, 'store'])
        ->name('inventory.store');

    Route::get('/inventory/deduct', [InventoryController::class, 'showDeductForm'])
        ->name('inventory.deduct.page');

    Route::post('/inventory/deduct', [InventoryController::class, 'deduct'])
        ->name('inventory.deduct');

    Route::get('/inventory/{item}/history', [InventoryController::class, 'history'])
        ->name('inventory.history');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
