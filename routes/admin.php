<?php

use Illuminate\Support\Facades\Route;

Route::any('admin/login', 'Admin\UserController@login')->name('login');

Route::prefix('admin')->middleware(['auth', 'admin'])->namespace('Admin')->group(function() {

    Route::get('/', 'IndexController@index');
    Route::any('logout', 'UserController@logout');

    Route::get('post/list', 'PostController@list');
    Route::any('post/edit', 'PostController@edit');
    Route::post('post/destroy', 'PostController@destroy');

    Route::post('post/image/upload', 'PostController@uploadImage');
    Route::post('post/image/remove', 'PostController@removeImage');

    Route::get('comment/list', 'CommentController@list');
    Route::post('comment/destroy', 'CommentController@destroy');

    Route::get('tag/list', 'TagController@list');
    Route::any('tag/edit', 'TagController@edit');
    Route::post('tag/destroy', 'TagController@destroy');

    Route::get('series/list', 'SeriesController@list');
    Route::any('series/edit', 'SeriesController@edit');
    Route::any('series/destroy', 'SeriesController@destroy');

    Route::get('link/list', 'LinkController@list');
    Route::any('link/edit', 'LinkController@edit');
    Route::any('link/destroy', 'LinkController@destroy');

});
