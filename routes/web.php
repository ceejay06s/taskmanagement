<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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


Auth::routes();
Route::group(['middleware' => ['web']], function () {
    Route::get('storage/{filename}', function ($filename) {
        $userid = session()->get('user')->id;
        return Storage::get($userid . '/' . $filename);
    });
});
Route::any('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/bin', [App\Http\Controllers\HomeController::class, 'bintodo'])->name('bintodo');
Route::any('/account', [App\Http\Controllers\HomeController::class, 'accounts'])->name('account');
//Route::get('/search/{sort}/{search}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/addtodo', [App\Http\Controllers\HomeController::class, 'addtodo'])->name('addtodo');
Route::match(['get', 'post'], '/addtodo/{item}', [App\Http\Controllers\HomeController::class, 'addtodo'])->name('addtodo');
Route::match(['get', 'post'], '/edittodo/{id}/{item}', [App\Http\Controllers\HomeController::class, 'edittodo'])->name('edittodo');
Route::match(['get', 'post'], '/edittodo/{id}', [App\Http\Controllers\HomeController::class, 'edittodo'])->name('edittodo');

Route::get('/updatetodo/{task}/{type}', [App\Http\Controllers\HomeController::class, 'updateTask'])->name('updatetodo');
