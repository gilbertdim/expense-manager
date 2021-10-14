<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;

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
    if(auth()) return redirect()->route('dashboard');
    
    return view('auth.login');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('profile');
    Route::post('/profile', [ UserController::class, 'changePassword' ])->name('profile.post');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', function(){
        if(request()->user()->role_id == 1) return view('user.index');
        return redirect()->route('dashboard');
    })->name('users');

    Route::get('/user/roles', function(){
        if(request()->user()->role_id == 1) return view('user.roles');
        return redirect()->route('dashboard');
    })->name('user.roles');

    Route::get('/expenses/category', function(){
        if(request()->user()->role_id == 1) return view('expense.category');
        return redirect()->route('dashboard');
    })->name('expenses.category');

    Route::get('/expenses', function(){
        return view('expense.index');
    })->name('expenses');
});


require __DIR__.'/auth.php';
