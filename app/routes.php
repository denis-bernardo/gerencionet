<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::group(['before' => 'guest'], function() {
    Route::get('/login/', function() {
        return View::make('login');
    });

    Route::post('/login/', ['uses' => 'AuthController@login']);
    Route::get('/login/forget', ['as' => 'login.reminder', 'uses' => 'RemindersController@getRemind']);
    Route::post('/login/forget', ['as' => 'login.reminder.post', 'uses' => 'RemindersController@postRemind']);
    Route::get('/password/reset/{token}', ['as' => 'login.reset', 'uses' => 'RemindersController@getReset']);
    Route::post('/password/reset', ['as' => 'login.reset.post', 'uses' => 'RemindersController@postReset']);
});

Route::group(['before' => 'auth'], function() {
    
    Route::get('logout', ['uses' => 'AuthController@logout']);
    
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/', ['as' => 'admin.index', 'uses' => 'AdminController@index']);
        Route::resource('clientes', 'ClienteController');
        Route::get('/clientes/{id}/pedidos', ['as' => 'admin.clientes.pedidos', 'uses' => 'ClienteController@pedidos']);
        Route::resource('funcionarios', 'FuncionarioController');
        Route::resource('mesas', 'MesaController');
        Route::resource('contas', 'ContaController');
        Route::resource('unidades', 'UnidadeController');
        Route::resource('estoque', 'EstoqueController');
        Route::resource('categorias', 'CategoriaController');
        Route::resource('usuarios', 'UsuarioController');
        Route::get('/produtos/estoque/{id}', ['as' => 'admin.produtos.estoque', 'uses' => 'ProdutoController@estoque']);
        Route::resource('produtos', 'ProdutoController');
        Route::put('/pedidos/{id}/finish', ['as' => 'admin.pedidos.finish', 'uses' => 'PedidoController@finish']);
        Route::resource('pedidos', 'PedidoController');
        Route::get('/pedidos-estatisticas', ['as' => 'admin.pedidos.stats', 'uses' => 'PedidoController@stats']);
        Route::resource('busca', 'BuscaController', ['only' => 'store']);
        Route::post('/birthdate/{id}', ['as' => 'admin.clientes.birthdate', 'uses' => 'ClienteController@birthdate']);
        Route::get('configuracoes', ['as' => 'admin.config.index', 'uses' => 'ConfigController@index']);
        Route::get('configuracoes/testar-envio', ['as' => 'admin.config.teste.envio', 'uses' => 'ConfigController@testarEnvio']);
        Route::post('/configuracoes/gerais', ['as' => 'admin.config.gerais', 'uses' => 'ConfigController@gerais']);
        Route::put('/configuracoes/gerais/{id}', ['as' => 'admin.config.gerais.update', 'uses' => 'ConfigController@geraisUpdate']);
        Route::post('/configuracoes/emails', ['as' => 'admin.config.emails', 'uses' => 'ConfigController@emails']);
        Route::put('/configuracoes/emails/{id}', ['as' => 'admin.config.emails.update', 'uses' => 'ConfigController@emailsUpdate']);
    });
});

/* View composers */
View::composer('partials.header', 'HeaderComposer');