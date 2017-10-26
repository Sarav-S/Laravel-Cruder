<?php
/**
 * Auth Middleware for these routes have been applied on 
 * RouteServiceProvider class.
 */

Route::get('profile', ['uses' => 'ProfileController@profile', 'as' => 'user.profile']);
Route::put('profile', 'ProfileController@updateProfile');
