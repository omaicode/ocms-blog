<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(config('core.admin_prefix', 'admin').'/blog')
->as('admin.blog.')
->middleware('auth')
->group(function() {
    Route::post('categories/destroy', 'Admin\\CategoryController@deletes')->name('categories.destroy');
    Route::post('posts/destroy', 'Admin\\CategoryController@deletes')->name('posts.destroy');

    Route::resource('categories', 'Admin\\CategoryController', ['except' => 'destroy']);
    Route::resource('posts', 'Admin\\PostController', ['except' => 'destroy']);
});