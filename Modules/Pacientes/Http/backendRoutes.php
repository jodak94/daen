<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/pacientes'], function (Router $router) {
    $router->bind('paciente', function ($id) {
        return app('Modules\Pacientes\Repositories\PacienteRepository')->find($id);
    });
    $router->get('pacientes', [
        'as' => 'admin.pacientes.paciente.index',
        'uses' => 'PacienteController@index',
        'middleware' => 'can:pacientes.pacientes.index'
    ]);
    $router->get('pacientes/index-ajax', [
        'as' => 'admin.pacientes.paciente.index_ajax',
        'uses' => 'PacienteController@index_ajax',
        'middleware' => 'can:pacientes.pacientes.index'
    ]);
    $router->get('pacientes/create', [
        'as' => 'admin.pacientes.paciente.create',
        'uses' => 'PacienteController@create',
        'middleware' => 'can:pacientes.pacientes.create'
    ]);
    $router->post('pacientes', [
        'as' => 'admin.pacientes.paciente.store',
        'uses' => 'PacienteController@store',
        'middleware' => 'can:pacientes.pacientes.create'
    ]);
    $router->get('pacientes/{paciente}/edit', [
        'as' => 'admin.pacientes.paciente.edit',
        'uses' => 'PacienteController@edit',
        'middleware' => 'can:pacientes.pacientes.edit'
    ]);
    $router->get('pacientes/get-analisis-id', [
        'as' => 'admin.pacientes.paciente.get_analisis_id',
        'uses' => 'PacienteController@get_analisis_id',
    ]);
    $router->post('pacientes/store_ajax', [
        'as' => 'admin.pacientes.paciente.store_ajax',
        'uses' => 'PacienteController@store_ajax',
        'middleware' => 'can:pacientes.pacientes.create'
    ]);
    $router->put('pacientes/{paciente}', [
        'as' => 'admin.pacientes.paciente.update',
        'uses' => 'PacienteController@update',
        'middleware' => 'can:pacientes.pacientes.edit'
    ]);
    $router->delete('pacientes/{paciente}', [
        'as' => 'admin.pacientes.paciente.destroy',
        'uses' => 'PacienteController@destroy',
        'middleware' => 'can:pacientes.pacientes.destroy'
    ]);
    $router->get('pacientes/search_ajax', [
        'as' => 'admin.pacientes.paciente.search_ajax',
        'uses' => 'PacienteController@search_ajax',
    ]);
    $router->get('pacientes/importar', [
        'as' => 'admin.pacientes.paciente.get_importar',
        'uses' => 'PacienteController@get_importar',
    ]);
    $router->post('pacientes/importar', [
        'as' => 'admin.pacientes.paciente.post_importar',
        'uses' => 'PacienteController@post_importar',
    ]);
    $router->post('pacientes/validation', [
        'as' => 'admin.pacientes.paciente.validation',
        'uses' => 'PacienteController@validation',
    ]);
    $router->post('pacientes/store-massive-ajax', [
        'as' => 'admin.pacientes.paciente.store_massive_ajax',
        'uses' => 'PacienteController@store_massive_ajax',
    ]);
// append

});
