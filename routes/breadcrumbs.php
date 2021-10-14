<?php

use App\Models\Link;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/*
|--------------------------------------------------------------------------
| Frontend Breadcrumbs
|--------------------------------------------------------------------------
*/

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push(trans('app.menu.dashboard'), route('dashboard'));
});

// Links - Index
Breadcrumbs::for('links.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('app.menu.links'), route('links.index'));
});

// Links - Create
Breadcrumbs::for('links.create', function (BreadcrumbTrail $trail) {
    $trail->parent('links.index');
    $trail->push(trans('app.menu.links-create'), route('links.create'));
});

// Links - Create
Breadcrumbs::for('links.edit', function (BreadcrumbTrail $trail, Link $link) {
    $trail->parent('links.index');
    $trail->push(
        trans('app.menu.links-edit', ['identifier' => Str::limit($link->title, 10)]),
        route('links.edit', $link)
    );
});

/*
|--------------------------------------------------------------------------
| Backend Breadcrumbs
|--------------------------------------------------------------------------
*/

// Admin - Dashboard
Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(
        trans('app.menu.admin'),
        '#' // TODO : Swap this once is done
        //route('admin.dashboard')
    );
});

// Admin - Links - Manage
Breadcrumbs::for('admin.links.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push(trans('app.menu.admin-links'), route('admin.links.index'));
});
