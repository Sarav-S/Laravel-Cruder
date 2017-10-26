<?php

Route::group(['prefix' => config('admin.url')], function(){
	Route::get('/', function(){
		return redirect(route('admin.login'));
	});

	Route::group(['middleware' => 'admin.guest'], function(){
		// Authentication Routes...
		Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
		Route::post('login', 'Admin\LoginController@login');

		// Password Reset Routes...
		Route::get('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
		Route::post('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
		Route::get('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
		Route::post('password/reset', 'Admin\ResetPasswordController@reset');
	});

	Route::group(['middleware' => 'admin.auth'], function() {
		Route::get('/dashboard', 'Admin\HomeController@dashboard')->name('admin.dashboard');
		Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
	});
});