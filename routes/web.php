<?php

use App\Livewire\Auth\Login;
use App\Livewire\Settings\Account;
use App\Livewire\Settings\Security;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest', 'prevent.back.history'])->group(function () {
    Route::get('login', Login::class)->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('pengaturan', Account::class)->name('settings');
    Route::get('pengaturan/keamanan', Security::class)->name('settings.security');
});
