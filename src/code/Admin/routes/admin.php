<?php

/**
 * Admin Auth Middleware for these routes have been applied on 
 * RouteServiceProvider class.
 */

Route::get('profile', ['uses' => 'Admin\ProfileController@profile'])->name('profile');
Route::put('profile', ['uses' => 'Admin\ProfileController@updateProfile'])->name('profile.update');

Route::resource('admins', 'Admin\AdminController');