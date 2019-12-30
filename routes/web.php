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

Route::group([
	'middleware' => ['auth'],
	'prefix' => 'transactions'
], function() {


	Route::get('/create', [
		'uses' => 'TransactionsController@create',
		'as' => 'transactions.create'
	]);

	Route::get('/{category?}', [
		'uses' => 'TransactionsController@index',
		'as' => 'transactions.index'
	]);
	
	Route::post('/', [
		'uses' => 'TransactionsController@store',
		'as' => 'transactions.store'
	]);

});



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
