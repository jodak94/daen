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
    $router->get('pacientes/{paciente}/historial', [
        'as' => 'admin.pacientes.paciente.historial',
        'uses' => 'PacienteController@historial',
        'middleware' => 'can:pacientes.pacientes.historial'
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
// append

});
