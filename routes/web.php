<?php

use Illuminate\Support\Facades\Route;
use  \App\Http\Controllers\ArticuloController;
use App\Http\Controllers\HomeController;

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

Route::get('/home', function () {
    return view('/home');
});
Route::get('/', function () {
    return view('/welcome');
});

Auth::routes();

Route::get('/user', [HomeController::class, 'getUser']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::apiResource('/articulos', App\Http\Controllers\ArticuloController::class);
