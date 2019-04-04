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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/payment', 'Payment\PaymentController@index');

Route::post('/pay', 'Payment\PaymentController@pay');

Route::prefix('admin')->middleware(['web', 'auth', 'check_profile'])->group(function () {
    Route::get('/', 'Admin\AdminController@index');

    /**
     * Empresa
     */
    Route::get('/empresa', 'Admin\EmpresaController@index');
    Route::put('/empresa/create', 'Admin\EmpresaController@put');
    Route::get('/empresa/create', 'Admin\EmpresaController@create');

    /**
     * Produtos
     */
    Route::get('/produtos', 'Admin\ProdutoController@index');
});
