<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/empresas'], function (Router $router) {
    $router->bind('empresa', function ($id) {
        return app('Modules\Empresas\Repositories\EmpresaRepository')->find($id);
    });
    $router->get('empresas', [
        'as' => 'admin.empresas.empresa.index',
        'uses' => 'EmpresaController@index',
        'middleware' => 'can:empresas.empresas.index'
    ]);
    $router->get('empresas/create', [
        'as' => 'admin.empresas.empresa.create',
        'uses' => 'EmpresaController@create',
        'middleware' => 'can:empresas.empresas.create'
    ]);
    $router->post('empresas', [
        'as' => 'admin.empresas.empresa.store',
        'uses' => 'EmpresaController@store',
        'middleware' => 'can:empresas.empresas.create'
    ]);
    $router->get('empresas/{empresa}/edit', [
        'as' => 'admin.empresas.empresa.edit',
        'uses' => 'EmpresaController@edit',
        'middleware' => 'can:empresas.empresas.edit'
    ]);
    $router->put('empresas/{empresa}', [
        'as' => 'admin.empresas.empresa.update',
        'uses' => 'EmpresaController@update',
        'middleware' => 'can:empresas.empresas.edit'
    ]);
    $router->delete('empresas/{empresa}', [
        'as' => 'admin.empresas.empresa.destroy',
        'uses' => 'EmpresaController@destroy',
        'middleware' => 'can:empresas.empresas.destroy'
    ]);
    $router->get('empresas/search_ajax', [
        'as' => 'admin.empresas.empresa.search_ajax',
        'uses' => 'EmpresaController@search_ajax',
    ]);
// append

});
