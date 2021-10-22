<?php

use App\Models\Link;
use App\Models\Tag;
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
| Admin - Backend Breadcrumbs
|--------------------------------------------------------------------------
*/

// Admin - Dashboard
Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('app.menu.admin'), '#');
});

/*
|--------------------------------------------------------------------------
| Admin Breadcrumbs - Links
|--------------------------------------------------------------------------
*/
Breadcrumbs::for('admin.links.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push(trans('app.menu.admin-links'), route('admin.links.index'));
});

// Links - Edit
Breadcrumbs::for('admin.links.edit', function (BreadcrumbTrail $trail, Link $link) {
    $trail->parent('admin.links.index');
    $trail->push(trans('app.menu.links-edit', ['identifier' => \Str::limit($link->title,30)]), route('admin.links.edit',$link));
});

/*
|--------------------------------------------------------------------------
| Admin Breadcrumbs - Tags
|--------------------------------------------------------------------------
*/

// Tags - Index
Breadcrumbs::for('admin.tags.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push(trans('app.menu.admin-tags'), route('admin.tags.index'));
});

// Tags - Edit
Breadcrumbs::for('admin.tags.edit', function (BreadcrumbTrail $trail, Tag $tag) {
    $trail->parent('admin.tags.index');
    $trail->push(trans('app.menu.tags-edit', ['identifier' => $tag->name]), route('admin.tags.edit',$tag));
});

// Tags - Create
Breadcrumbs::for('admin.tags.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tags.index');
    $trail->push(trans('app.menu.tags-create'), route('admin.tags.create'));
});
