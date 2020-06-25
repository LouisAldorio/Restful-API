<?php


Route::get('welcome', 'API\v1\WelcomeController@index');

Route::post('register','API\v1\AuthController@register');

Route::post('login','API\v1\AuthController@login');

Route::post('logout','API\v1\AuthController@logout');

Route::group(['middleware' => 'auth:api'],function(){

    //employee controller
    Route::get('employees','API\v1\EmployeeController@index');

    Route::get('employees/{id}','API\v1\EmployeeController@show');

    Route::post('employees','API\v1\EmployeeController@store');

    Route::put('employees/{id}','API\v1\EmployeeController@update');

    Route::delete('employees/{id}','API\v1\EmployeeController@destroy');
});