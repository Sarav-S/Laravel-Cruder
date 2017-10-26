<?php

Breadcrumbs::register('admin', function($breadcrumbs){
    $breadcrumbs->push('Home', route('admin.dashboard'));
});

Breadcrumbs::register('home', function($breadcrumbs){
    $breadcrumbs->push('Home', url('/'));
});
