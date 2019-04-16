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

Route::get('/categorias/all', 'Categoria\CategoriaController@categorias');

Route::get('/produtos_categoria/{id_categoria}', 'Produto\ProdutoController@produtos_categorias');

Route::prefix('admin')->middleware(['web', 'auth', 'check_profile'])->group(function () {
    Route::get('/', 'Admin\AdminController@index');

    /**
     * Empresa
     */
    Route::get('/empresa', 'Admin\EmpresaController@index');
    Route::get('/empresa/create', 'Admin\EmpresaController@create');
    Route::put('/empresa/create', 'Admin\EmpresaController@put');

    /**
     * Produtos
     */
    Route::get('/produtos', 'Admin\ProdutoController@index');
    Route::get('/produtos/{id_categoria}', 'Admin\ProdutoController@produtos_categoria');
    Route::put('/produto/create', 'Admin\ProdutoController@put');
    Route::get('/categorias/all', 'Admin\ProdutoController@categorias');
    Route::put('/categoria/create', 'Admin\CategoriaController@put');
});

Route::prefix('cliente')->middleware(['web', 'auth', 'check_profile'])->group(function () {
    Route::get('/', 'Cliente\ClienteController@profile');
    Route::get('/add_produto/{id_produto}', 'Cliente\CarrinhoController@addProduto');
    Route::get('/remove_produto/{id_produto}', 'Cliente\CarrinhoController@removeProduto');
    Route::get('/carrinho', 'Cliente\CarrinhoController@carrinho');
});
