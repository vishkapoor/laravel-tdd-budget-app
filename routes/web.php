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

// 

Route::resource('transactions', 'TransactionsController', [
	'except' => [ 'show' ]
])->middleware(['auth']);

Route::get('/transactions/{category?}', [
	'uses' => 'TransactionsController@index',
	'as' => 'transactions.index'
]);

Route::resource('categories', 'CategoriesController')
	->middleware(['auth']);


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
