<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\TtbController;
use App\models\food;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/food', function() {
//     return food::all();
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UsersController::class, 'users']);
Route::get('foods', [UsersController::class, 'foods']);
Route::post('foods', [UsersController::class, 'store']);
Route::get('foods/{id}', [UsersController::class, 'showfood']);
Route::put('foods/{id}', [UsersController::class, 'updatefood']);

// Route::post('/usersbooking', [UsersController::class, 'store']);
Route::post('/ttbbooking', [TtbController::class, 'store']);
Route::post('/food', [UsersController::class, 'update']);

Route::get('tents', [UsersController::class, 'tents']);
