<?php

Route::group(["prefix" => "v1"], function(){
    Route::post('register', 'Api\AuthController@register');
    Route::post('otp/generate', 'Api\AuthController@generateOtp');
    Route::post('login', 'Api\AuthController@login');
    Route::post('id/forgot', 'Api\AuthController@mailLoginId');
});