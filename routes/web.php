<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('/home');
});

Auth::routes();

Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/UserAccount/{id}', [\App\Http\Controllers\UserAccount::class, 'index'])->middleware('auth');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user');
    Route::get('/items', [\App\Http\Controllers\ItemsController::class, 'index'])->name('items');
    Route::get('/requests', [\App\Http\Controllers\RequestsController::class, 'index'])->name('requests');
});

Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/logs', [\App\Http\Controllers\LogsController::class, 'index'])->name('logs');
    Route::get('/transactions/{id}', [\App\Http\Controllers\TransactionsController::class, 'index'])->name('Transactions');
    Route::get('/cart/{id}', [\App\Http\Controllers\ItemUserController::class, 'index'])->name('cart');
    Route::get('/catalog', [\App\Http\Controllers\CatalogController::class, 'index'])->name('catalog');
});

Route::group(['middleware' => ['auth', 'status']], function () {
    Route::get('/transactions/{id}', [\App\Http\Controllers\TransactionsController::class, 'index'])->name('Transactions');
});



Route::post('/transaction/{user_id}', [\App\Http\Controllers\TransactionsController::class, 'store'])->middleware('auth');
Route::put('/Approve_request/{id}/{serial_code}', [\App\Http\Controllers\RequestsController::class, 'update'])->middleware('auth');




//cart crud
Route::post('/add_cart/{user_id}/{item_id}', [\App\Http\Controllers\ItemUserController::class, 'store']);
Route::put('/edit_date/{id}', [\App\Http\Controllers\ItemUserController::class, 'update']);
Route::delete('/delete_cart_item/{id}', [\App\Http\Controllers\ItemUserController::class, 'destroy']);


//user_account crud
Route::put('/UserAccount_update/{id}', [\App\Http\Controllers\UserAccount::class, 'update']);

//user crud
Route::put('/user/{id}', [\App\Http\Controllers\UserController::class, 'update']);
Route::delete('/user/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

//item crud
Route::post('/AddItem', [\App\Http\Controllers\ItemsController::class, 'create']);
Route::delete('/DeleteItem/{id}', [\App\Http\Controllers\ItemsController::class, 'destroy']);
Route::put('/Edit_item/{id}', [\App\Http\Controllers\ItemsController::class, 'update']);

//serial crud
Route::get('/add_copy/{id}', [\App\Http\Controllers\SerialsController::class, 'create']);
Route::get('/delete_serial/{id}', [\App\Http\Controllers\SerialsController::class, 'destroy']);
