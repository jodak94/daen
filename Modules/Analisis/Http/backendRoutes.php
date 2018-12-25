<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/analisis'], function (Router $router) {
    $router->bind('analisis', function ($id) {
        return app('Modules\Analisis\Repositories\AnalisisRepository')->find($id);
    });
    $router->get('analises', [
        'as' => 'admin.analisis.analisis.index',
        'uses' => 'AnalisisController@index',
        'middleware' => 'can:analisis.analises.index'
    ]);
    $router->get('analises/create', [
        'as' => 'admin.analisis.analisis.create',
        'uses' => 'AnalisisController@create',
        'middleware' => 'can:analisis.analises.create'
    ]);
    $router->post('analises', [
        'as' => 'admin.analisis.analisis.store',
        'uses' => 'AnalisisController@store',
        'middleware' => 'can:analisis.analises.create'
    ]);
    $router->get('analises/{analisis}/edit', [
        'as' => 'admin.analisis.analisis.edit',
        'uses' => 'AnalisisController@edit',
        'middleware' => 'can:analisis.analises.edit'
    ]);
    $router->put('analises/{analisis}', [
        'as' => 'admin.analisis.analisis.update',
        'uses' => 'AnalisisController@update',
        'middleware' => 'can:analisis.analises.edit'
    ]);
    $router->delete('analises/{analisis}', [
        'as' => 'admin.analisis.analisis.destroy',
        'uses' => 'AnalisisController@destroy',
        'middleware' => 'can:analisis.analises.destroy'
    ]);
    $router->bind('seccion', function ($id) {
        return app('Modules\Analisis\Repositories\SeccionRepository')->find($id);
    });
    $router->get('seccions', [
        'as' => 'admin.analisis.seccion.index',
        'uses' => 'SeccionController@index',
        'middleware' => 'can:analisis.seccions.index'
    ]);
    $router->get('seccions/create', [
        'as' => 'admin.analisis.seccion.create',
        'uses' => 'SeccionController@create',
        'middleware' => 'can:analisis.seccions.create'
    ]);
    $router->post('seccions', [
        'as' => 'admin.analisis.seccion.store',
        'uses' => 'SeccionController@store',
        'middleware' => 'can:analisis.seccions.create'
    ]);
    $router->get('seccions/{seccion}/edit', [
        'as' => 'admin.analisis.seccion.edit',
        'uses' => 'SeccionController@edit',
        'middleware' => 'can:analisis.seccions.edit'
    ]);
    $router->put('seccions/{seccion}', [
        'as' => 'admin.analisis.seccion.update',
        'uses' => 'SeccionController@update',
        'middleware' => 'can:analisis.seccions.edit'
    ]);
    $router->delete('seccions/{seccion}', [
        'as' => 'admin.analisis.seccion.destroy',
        'uses' => 'SeccionController@destroy',
        'middleware' => 'can:analisis.seccions.destroy'
    ]);
    $router->bind('resultado', function ($id) {
        return app('Modules\Analisis\Repositories\ResultadoRepository')->find($id);
    });
    $router->get('resultados', [
        'as' => 'admin.analisis.resultado.index',
        'uses' => 'ResultadoController@index',
        'middleware' => 'can:analisis.resultados.index'
    ]);
    $router->get('resultados/create', [
        'as' => 'admin.analisis.resultado.create',
        'uses' => 'ResultadoController@create',
        'middleware' => 'can:analisis.resultados.create'
    ]);
    $router->post('resultados', [
        'as' => 'admin.analisis.resultado.store',
        'uses' => 'ResultadoController@store',
        'middleware' => 'can:analisis.resultados.create'
    ]);
    $router->get('resultados/{resultado}/edit', [
        'as' => 'admin.analisis.resultado.edit',
        'uses' => 'ResultadoController@edit',
        'middleware' => 'can:analisis.resultados.edit'
    ]);
    $router->put('resultados/{resultado}', [
        'as' => 'admin.analisis.resultado.update',
        'uses' => 'ResultadoController@update',
        'middleware' => 'can:analisis.resultados.edit'
    ]);
    $router->delete('resultados/{resultado}', [
        'as' => 'admin.analisis.resultado.destroy',
        'uses' => 'ResultadoController@destroy',
        'middleware' => 'can:analisis.resultados.destroy'
    ]);
    $router->bind('determinacion', function ($id) {
        return app('Modules\Analisis\Repositories\DeterminacionRepository')->find($id);
    });
    $router->get('determinacions', [
        'as' => 'admin.analisis.determinacion.index',
        'uses' => 'DeterminacionController@index',
        'middleware' => 'can:analisis.determinacions.index'
    ]);
    $router->get('determinacions/create', [
        'as' => 'admin.analisis.determinacion.create',
        'uses' => 'DeterminacionController@create',
        'middleware' => 'can:analisis.determinacions.create'
    ]);
    $router->post('determinacions', [
        'as' => 'admin.analisis.determinacion.store',
        'uses' => 'DeterminacionController@store',
        'middleware' => 'can:analisis.determinacions.create'
    ]);
    $router->get('determinacions/{determinacion}/edit', [
        'as' => 'admin.analisis.determinacion.edit',
        'uses' => 'DeterminacionController@edit',
        'middleware' => 'can:analisis.determinacions.edit'
    ]);
    $router->put('determinacions/{determinacion}', [
        'as' => 'admin.analisis.determinacion.update',
        'uses' => 'DeterminacionController@update',
        'middleware' => 'can:analisis.determinacions.edit'
    ]);
    $router->delete('determinacions/{determinacion}', [
        'as' => 'admin.analisis.determinacion.destroy',
        'uses' => 'DeterminacionController@destroy',
        'middleware' => 'can:analisis.determinacions.destroy'
    ]);
    $router->bind('plantilla', function ($id) {
        return app('Modules\Analisis\Repositories\PlantillaRepository')->find($id);
    });
    $router->get('plantillas', [
        'as' => 'admin.analisis.plantilla.index',
        'uses' => 'PlantillaController@index',
        'middleware' => 'can:analisis.plantillas.index'
    ]);
    $router->get('plantillas/create', [
        'as' => 'admin.analisis.plantilla.create',
        'uses' => 'PlantillaController@create',
        'middleware' => 'can:analisis.plantillas.create'
    ]);
    $router->post('plantillas', [
        'as' => 'admin.analisis.plantilla.store',
        'uses' => 'PlantillaController@store',
        'middleware' => 'can:analisis.plantillas.create'
    ]);
    $router->get('plantillas/{plantilla}/edit', [
        'as' => 'admin.analisis.plantilla.edit',
        'uses' => 'PlantillaController@edit',
        'middleware' => 'can:analisis.plantillas.edit'
    ]);
    $router->put('plantillas/{plantilla}', [
        'as' => 'admin.analisis.plantilla.update',
        'uses' => 'PlantillaController@update',
        'middleware' => 'can:analisis.plantillas.edit'
    ]);
    $router->delete('plantillas/{plantilla}', [
        'as' => 'admin.analisis.plantilla.destroy',
        'uses' => 'PlantillaController@destroy',
        'middleware' => 'can:analisis.plantillas.destroy'
    ]);
    
// append






});
