<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'auth:api'], function () {
    Route::put('update', 'UserController@update', 'user.update');
    Route::put('logout', 'UserController@logout', 'user.logout');

    Route::post('category','CategoryController@store', 'category.create');
    Route::get('category/{id}','CategoryController@show', 'category.show');
    Route::get('category','CategoryController@index', 'category.read');
    Route::put('category/{id}','CategoryController@update', 'category.update');
    Route::delete('category/{id}','CategoryController@destroy', 'category.delete');


    Route::post('/task', 'TaskController@store');
    Route::get('/task/{id}', 'TaskController@show');
    Route::get('/task', 'TaskController@index');
    Route::put('/task/{id}', 'TaskController@update');
    Route::put('/task/done/{id}', 'TaskController@done');
    Route::delete('/task/{id}', 'TaskController@destroy');

});

Route::post('register', 'UserController@register', 'user.register');
Route::post('login', 'UserController@login', 'user.login');


Route::group([
    'prefix' => 'password-reset'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});
