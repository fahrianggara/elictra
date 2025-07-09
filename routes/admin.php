<?php

use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', Dashboard::class)->name('admin.dashboard');
Route::get('pelanggan', Customers::class)->name('admin.customers');
