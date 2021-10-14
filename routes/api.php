<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user/role', function (Request $request) {
        return response()->json([
            'role' => $request->user()->role_id
        ]);
    });
    
    Route::get('users', [ UserController::class, 'list' ]);
    Route::post('users', [ UserController::class, 'save' ]);
    Route::post('users/delete', [ UserController::class, 'delete' ]);

    Route::get('user/roles', [ UserRoleController::class, 'list' ]);
    Route::post('user/roles', [ UserRoleController::class, 'save' ]);
    Route::post('user/roles/delete', [ UserRoleController::class, 'delete' ]);

    Route::get('expense/categories', [ ExpenseCategoryController::class, 'list' ]);
    Route::post('expenses/category', [ ExpenseCategoryController::class, 'save' ]);
    Route::post('expenses/category/delete', [ ExpenseCategoryController::class, 'delete' ]);

    Route::get('expenses', [ ExpenseController::class, 'list' ]);
    Route::get('expenses/summary', [ ExpenseController::class, 'summary' ]);
    Route::post('expenses', [ ExpenseController::class, 'save' ]);
    Route::post('expenses/delete', [ ExpenseController::class, 'delete' ]);

});
