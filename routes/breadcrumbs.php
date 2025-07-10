<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('master', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "javascript:void(0);");
});

Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('admin.customers', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Pelanggan', route('admin.customers'));
});

Breadcrumbs::for('admin.tarifs', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Tarif Listrik', route('admin.tarifs'));
});

Breadcrumbs::for('admin.payment_methods', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Metode Pembayaran', route('admin.payment_methods'));
});
