<?php

Breadcrumbs::register('admin.dashboard', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::register('admin.profile', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Profile', route('admin.profile'));
});

Breadcrumbs::register('admin.admins.index', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Admin Listing', route('admin.admins.index'));
});

Breadcrumbs::register('admin.admins.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Create Admin', route('admin.admins.create'));
});

Breadcrumbs::register('admin.admins.show', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $segment = urlsegment();
    $breadcrumbs->push('View Admin', route('admin.admins.show', $segment));
});

Breadcrumbs::register('admin.admins.edit', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $segment = urlsegment();
    $breadcrumbs->push('Edit Admin', route('admin.admins.edit', $segment));
});
