<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::post('/reservasi', [GuestController::class, 'store'])->name('guest.store');
Route::get('/tracking', [GuestController::class, 'tracking'])->name('guest.tracking');