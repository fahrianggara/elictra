<?php

use App\Livewire\Customer\BillHistories;
use App\Livewire\Customer\Bills;
use App\Livewire\Customer\Dashboard;
use App\Livewire\Customer\Payments;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Route::get('/', function () {
    return redirect()->route('customer.dashboard');
});

Route::group(['as' => 'customer.'], function() {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('tagihan', Bills::class)->name('bills');
    Route::get('bayar/{invoice}', Payments::class)->name('payments');
    Route::get('riwayat-tagihan', BillHistories::class)->name('bills.history');
});

Breadcrumbs::for('customer.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('customer.dashboard'));
});

Breadcrumbs::for('customer.bills', function (BreadcrumbTrail $trail) {
    $trail->push('Tagihan', route('customer.bills'));
});

Breadcrumbs::for('customer.payments', function (BreadcrumbTrail $trail, $invoice) {
    $trail->parent('customer.bills');
    $trail->push('Pembayaran', route('customer.payments', ['invoice' => $invoice]));
});

Breadcrumbs::for('customer.bills.history', function (BreadcrumbTrail $trail) {
    $trail->push('Riwayat Tagihan', route('customer.bills.history'));
});
