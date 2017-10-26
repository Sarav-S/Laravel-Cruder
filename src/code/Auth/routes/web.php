<?php

Route::group(['middleware' => 'guest'], function(){

	// Authentication Routes...
	Route::get('login', 'LoginController@showLoginForm')->name('login');
	Route::post('login', 'LoginController@login');

	// Registration Routes...
	Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'RegisterController@register');

	// Password Reset Routes...
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'ResetPasswordController@reset');

	Route::get('social/auth/redirect/{provider}', 'LoginController@redirectToProvider')->name('social.login');
	Route::get('social/auth/{provider}', 'LoginController@handleProviderCallback')->name('social.login.callback');

	Route::get('twitter/email', 'LoginController@getEmailFromTwitter')->name('twitter.email');
	Route::post('twitter/email', 'LoginController@postEmailFromTwitter')->name('twitter.email.post');
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
	Route::post('logout', 'LoginController@logout')->name('logout');
});