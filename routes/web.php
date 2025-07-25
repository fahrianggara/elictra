<?php

use App\Http\Controllers\PrintController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Settings\Account;
use App\Livewire\Settings\Security;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['guest', 'prevent.back.history'])->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('pengaturan', Account::class)->name('settings');
    Route::get('pengaturan/keamanan', Security::class)->name('settings.security');

    Route::get('print/tagihan/{payment_id}', [PrintController::class, 'bill'])->name('print.bill');
});
