<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/start', 'HomeController@start');

//Route::resource('/player', 'PlayerController');
Route::apiResource('/player','Player\PlayerController');
Route::resource('/profile','v1\ProfileController')->middleware('auth');
Route::resource('/chat','v1\ChatController')->middleware('auth');
Route::apiResource('/chat/{another_player_id}/comment','v1\CommentController')->middleware('auth');
