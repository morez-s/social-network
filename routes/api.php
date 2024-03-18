<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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



/*
|--------------------------------------------------------------------------
| Routes For Guest Users
|--------------------------------------------------------------------------
*/

// ********** Authentication ********** //

Route::post('/auth/registration', [AuthController::class, 'registration'])->name('registration');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');



/*
|--------------------------------------------------------------------------
| Routes For Authenticated Users
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'check_if_user_is_not_banned']], function()
{
    // ************** Posts ************** //

    Route::apiResource('/posts', PostController::class)->only('store')->names([
        'store' => 'posts.store',
    ]);

});
