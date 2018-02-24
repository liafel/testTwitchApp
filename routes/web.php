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

Route::get('/', function () {
    return view('welcome');
});

# Маршруты для страницы управления играми
Route::get('/games', 'GameController@index');
Route::post('/game', 'GameController@store');
Route::delete('/game/{game}', 'GameController@destroy');
Route::get('/search-game', 'GameController@search');

# Ресурс для API
Route::resource('/api','ApiController')->middleware('auth:api');

# Регистрация машрутов авторизации
Auth::routes();

# Страница выдачи токенов
Route::get('/home', 'HomeController@index')->name('home');
