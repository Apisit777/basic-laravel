<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TestDataUsersController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UsersController::class, 'showusers']);
Route::post('/post', [UsersController::class, 'store']);
Route::post('/checknamebrand', [UsersController::class, 'checkname_brand'])->name('checknamebrand');

Route::get('/importform', [TestDataUsersController::class, 'importForm']);
Route::post('/importform', [TestDataUsersController::class, 'saveImportFile']);
// Route::match(['get', 'post'], '/checknamebrand', [UsersController::class, 'checkname_brand'])->name('checknamebrand');
