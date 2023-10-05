<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\OptionController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\RolePermissionController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/', [MenuController::class, 'index']);

    Route::prefix('orders')->group(function () {
        Route::get('{order}', [OrderController::class, 'show'])->middleware('check.order.access');
        Route::post('/', [OrderController::class, 'store']);
        Route::delete('{id}/cancel', [OrderController::class, 'cancel'])->middleware('check.order.access');
    });

    Route::middleware(['role:admin'])->group(function () {

        Route::post('/roles', [RolePermissionController::class, 'createRole']);
        Route::post('/permissions', [RolePermissionController::class, 'createPermission']);
        Route::post('/assign-role', [RolePermissionController::class, 'assignRole']);
        Route::post('/give-permission', [RolePermissionController::class, 'givePermission']);

        Route::resource('users', UsersController::class);

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('{category}', [CategoryController::class, 'show']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('{category}', [CategoryController::class, 'update']);
            Route::delete('{category}', [CategoryController::class, 'destroy']);
        });

        Route::prefix('products')->group(function () {
            Route::get('{product}/options', [OptionController::class, 'index']);
            Route::get('{product}/options/{option}', [OptionController::class, 'show']);
            Route::post('{product}/options', [OptionController::class, 'store']);
            Route::put('{product}/options/{option}', [OptionController::class, 'update']);
            Route::delete('{product}/options/{option}', [OptionController::class, 'destroy']);
        });

        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::put('{id}/update-status', [OrderController::class, 'updateStatus']);
        });

    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
