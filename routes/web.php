<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'PostController@index');
Route::get('post', 'PostController@index');
Route::get('post/{post}', 'PostController@show');
Route::get('archive', 'PostController@archive');
Route::post('comment', 'CommentController@comment');

require __DIR__ . '/admin.php';