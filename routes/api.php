<?php
/**
 * Try to use methods from BaseController (App\Http\Controllers\BaseController)
 *
 * GET getAll -> route-name ?+ params (for 'where')
 * GET getOne -> route-name/{id} ?+ params (for 'where')
 * POST createOne -> route-name + data
 * PUT updateOne -> route-name/{id} + data
 * DELETE deleteOne -> route-name/{id}
 */

Route::group(['middleware' => 'language'], function () {

    Route::post('login', 'User\\AuthController@login');
    Route::post('register', 'User\\AuthController@register');
    Route::post('refresh-token', 'User\\AuthController@refreshToken');

    Route::group(['middleware' => 'jwt-auth:user'], function () {
        Route::get('user', 'User\\UserController@getOne');
        Route::put('user/{id}', 'User\\UserController@updateOne');

        Route::post('logout', 'User\\AuthController@logout');
    });

    Route::post('message', 'Message\\MessageController@createOne');
});
