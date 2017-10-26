<?php 

Route::get('create', 'ModuleCreatorController@getForm')->name('mc.create');

Route::post('create', 'ModuleCreatorController@postForm')->name('mc.create.post');

Route::get('test', 'ModuleCreatorController@test');

Route::get('generate/routes', 'ModuleCreatorController@generateRoutes');

Route::get('initialize', 'ModuleCreatorController@initializeCoreModules')->name('mc.initialize');