<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest', 'prevent.back.history'])->group(function () {
    Route::get('login', Login::class)->name('login');
});
