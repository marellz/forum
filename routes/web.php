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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'HomeController@search')->name('search');

Route::prefix('thread')->group(function() {
  // create
  Route::get('/create',function(){return view('thread.create');})->name('create-thread');
  Route::post('/create','ThreadController@create');

  // view
  Route::get('/view/{code}','ThreadController@view')->name('view-thread');
  Route::get('/fetch/{code}','ThreadController@fetch')->name('fetch-thread');

  // comment
  Route::post('view/{code}/comment','ReplyController@create')->name('new-reply');

});

//likes
Route::post('/like/{code}','LikeController@like')->name('like-item');

//delete
Route::post('/delete-reply/{code}','ReplyController@delete')->name('delete-reply');

//notifications
Route::prefix('notifications')->group(function(){
  Route::get('/fetch','NotifyController@fetch')->name('fetch-notifications');
  Route::get('/action/{code}','NotifyController@action')->name('notification-action');
  Route::post('/action/{code}/delete','NotifyController@delete')->name('notification-action');
});

// AUTH
Route::get('/login',function(){
  return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/register',function(){
  return view('auth.register');
})->name('register')->middleware('guest');

Route::get('/reset_email',function(){
  return view('auth.reset');
})->name('reset')->middleware('guest');


Route::get('/logout','AuthController@logout')->name('logout');
Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');
Route::post('/reset_email','AuthController@reset_email');

//reset link
Route::get('/reset_password/{token}','AuthController@reset_password')->name('reset_password');
Route::post('/reset_password/{token}','AuthController@new_password');
