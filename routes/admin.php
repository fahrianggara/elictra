<?php

use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\PaymentMethods;
use App\Livewire\Admin\Tarifs;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin'], function () {
    Route::get('dashboard', Dashboard::class)->name('.dashboard');
    Route::get('pelanggan', Customers::class)->name('.customers');
    Route::get('tarif-listrik', Tarifs::class)->name('.tarifs');
    Route::get('metode-pembayaran', PaymentMethods::class)->name('.payment_methods');
});
