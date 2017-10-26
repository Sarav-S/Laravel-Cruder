<?php

Route::get('settings', ['as' => 'admin.settings.get', 'uses' => 'Admin\SettingsController@getSettings']);
Route::post('settings',  ['as' => 'admin.settings.post',  'uses' => 'Admin\SettingsController@postSettings']);
