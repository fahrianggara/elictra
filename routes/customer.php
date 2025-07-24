<?php

use App\Livewire\Customer\Bills;
use App\Livewire\Customer\Dashboard;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Route::get('/', function () {
    return redirect()->route('customer.dashboard');
});

Route::group(['as' => 'customer.'], function() {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('tagihan', Bills::class)->name('bills');
});

Breadcrumbs::for('customer.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('customer.dashboard'));
});

Breadcrumbs::for('customer.bills', function (BreadcrumbTrail $trail) {
    $trail->push('Tagihan', route('customer.bills'));
});
