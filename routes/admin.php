<?php

use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', Dashboard::class)->name('admin.dashboard');
