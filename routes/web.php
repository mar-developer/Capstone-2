<?php

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

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {

    Route::get('/user', 'UserController@index')->name('user')->middleware('auth');
    Route::get('/items', 'ItemsController@index')->name('items')->middleware('auth');
    Route::get( '/requests', 'RequestsController@index')->name('requests')->middleware('auth');

});

Route::group(['middleware' => 'App\Http\Middleware\UserMiddleware'], function () {

    Route::get('/transactions/{id}', 'TransactionsController@index')->name('Transactions')->middleware('auth');
    Route::get('/cart/{id}', 'ItemUserController@index')->name('cart')->middleware('auth');
    Route::get('/UserAccount/{id}', 'UserAccount@index')->middleware('auth');
    Route::get('/catalog', 'CatalogController@index')->name('catalog')->middleware('auth');

});


Route::group(['middleware' => 'App\Http\Middleware\StatusMiddleware'], function () {

    Route::get('/catalog', 'CatalogController@index')->name('catalog')->middleware('auth');
    Route::get('/cart/{id}', 'ItemUserController@index')->name('cart')->middleware('auth');
    Route::get('/transactions/{id}', 'TransactionsController@index')->name('Transactions')->middleware('auth');

});



Route::post('/transaction/{user_id}', 'TransactionsController@store')->middleware('auth');
Route::put('/Approve_request/{id}/{serial_code}', 'RequestsController@update')->middleware('auth');




//cart crud
Route::post('/add_cart/{user_id}/{item_id}', 'ItemUserController@store');
Route::put('/edit_date/{id}', 'ItemUserController@update');
Route::delete('/delete_cart_item/{id}', 'ItemUserController@destroy');


//user_account crud
Route::put('/UserAccount_update/{id}', 'UserAccountController@update');

//user crud
Route::put('/user/{id}', 'UserController@update');
Route::delete('/user/{id}', 'UserController@destroy');

//item crud
Route::post('/AddItem', 'ItemsController@create');
Route::delete('/DeleteItem/{id}', 'ItemsController@destroy');
Route::put('/Edit_item/{id}', 'ItemsController@update');

//serial crud
Route::get('/add_copy/{id}', 'SerialsController@create');
Route::get('/delete_serial/{id}', 'SerialsController@destroy');
