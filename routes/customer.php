<?php

use App\Livewire\Customer\Dashboard;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Route::group(['as' => 'customer.'], function() {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});

Breadcrumbs::for('customer.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('customer.dashboard'));
});
