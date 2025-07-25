<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->push('Admin', "javascript:void(0);");
});

Breadcrumbs::for('customer', function (BreadcrumbTrail $trail) {
    $trail->push('Pelanggan', "javascript:void(0);");
});

Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('admin.customers', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Pelanggan', route('admin.customers'));
});

Breadcrumbs::for('admin.tarifs', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Tarif Listrik', route('admin.tarifs'));
});

Breadcrumbs::for('admin.payment_methods', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Metode Pembayaran', route('admin.payment_methods'));
});

Breadcrumbs::for('admin.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Pengguna', route('admin.users'));
});

Breadcrumbs::for('admin.roles', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Peran Pengguna', route('admin.roles'));
});

Breadcrumbs::for('admin.bills', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Tagihan', route('admin.bills'));
});

Breadcrumbs::for('admin.payments', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Pembayaran', route('admin.payments'));
});

Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    // $trail->parent('admin');
    $trail->push('Pengaturan', route('settings'));
});

Breadcrumbs::for('settings.security', function (BreadcrumbTrail $trail) {
    // $trail->parent('admin');
    if (auth()->user()->role->name != 'pelanggan') {
        $trail->parent('settings');
    } else {
        $trail->push('Pengaturan', "javascript:void(0);");
    }

    $trail->push('Keamanan', route('settings.security'));
});
