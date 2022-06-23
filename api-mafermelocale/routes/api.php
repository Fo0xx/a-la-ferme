<?php

use App\Http\Controllers\API\AddressController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FarmController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\VoteController;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\CurrencyController;
use App\Http\Controllers\API\LangController;


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

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::post('loginadmin', [AuthController::class, 'signinAdmin']);

Route::get('farms', [FarmController::class, 'index']);
Route::get('farms/{id}', [FarmController::class, 'show']);
Route::get('farms/{longitude}/{latitude}/{radius}', [FarmController::class, 'getFarmsByRadius']);

/**
 * Only authenticated users can call the route named here
 */
Route::middleware(['auth:sanctum_user'])->group(function () {

    // Route for the farmer only (role_id = 1)
    Route::middleware(['ability:farm'])->group(function () {
        Route::post('farms', [FarmController::class, 'store']);
        Route::put('farms/{id}', [FarmController::class, 'update']);
        Route::delete('farms/{id}', [FarmController::class, 'destroy']);
    });

    Route::get('user', [UserController::class, 'getUser']);

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/{id}/farms', 'showFarm');
    });

    Route::apiResources([
        'users' => UserController::class,
        'addresses' => AddressController::class,
        'categories' => CategoryController::class,
        'votes' => VoteController::class
    ]);

    Route::post('logout', [AuthController::class, 'signoutUser']); // Logout user
});

Route::middleware(['auth:sanctum_admin'])->group(function () {
    
    Route::apiResources([
        'addresses' => AddressController::class,
        'categories' => CategoryController::class,
        'countries' => CountryController::class,
        'currencies' => CurrencyController::class,
        'langs' => LangController::class,
        'products' => ProductController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
        'votes' => VoteController::class,
        'roles' => RoleController::class,
    ]);

    Route::post('logoutadmin', [AuthController::class, 'signoutAdmin']); // Logout admin

});