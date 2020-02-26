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
    $router->get('analises/index-ajax', [
        'as' => 'admin.analisis.analisis.index_ajax',
        'uses' => 'AnalisisController@index_ajax',
        'middleware' => 'can:analisis.analises.index'
    ]);
    $router->get('analises/exportar', [
        'as' => 'admin.analisis.analisis.exportar',
        'uses' => 'AnalisisController@export_to_pdf',
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
    $router->post('seccions/ordenar', [
        'as' => 'admin.analisis.seccion.ordenar',
        'uses' => 'SeccionController@ordenar',
        'middleware' => 'can:analisis.seccions.ordenar'
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
    $router->get('secciones/subseccion', [
      'as' => 'admin.analisis.seccion.subseccion',
      'uses' => 'SeccionController@subseccion',
    ]);
    $router->get('secciones/search_ajax', [
        'as' => 'admin.analisis.seccion.search_ajax',
        'uses' => 'SeccionController@search_ajax',
    ]);
    $router->bind('subseccion', function ($id) {
        return app('Modules\Analisis\Repositories\SubseccionRepository')->find($id);
    });
    $router->get('subseccions', [
        'as' => 'admin.analisis.subseccion.index',
        'uses' => 'SubseccionController@index',
        'middleware' => 'can:analisis.subseccions.index'
    ]);

    $router->get('subseccions/create', [
        'as' => 'admin.analisis.subseccion.create',
        'uses' => 'SubseccionController@create',
        'middleware' => 'can:analisis.subseccions.create'
    ]);
    $router->post('subseccions', [
        'as' => 'admin.analisis.subseccion.store',
        'uses' => 'SubseccionController@store',
        'middleware' => 'can:analisis.subseccions.create'
    ]);
    $router->post('subseccions/ordenar', [
        'as' => 'admin.analisis.subseccion.ordenar',
        'uses' => 'SubseccionController@ordenar',
        'middleware' => 'can:analisis.subseccions.ordenar'
    ]);
    $router->get('subseccions/{subseccion}/edit', [
        'as' => 'admin.analisis.subseccion.edit',
        'uses' => 'SubseccionController@edit',
        'middleware' => 'can:analisis.subseccions.edit'
    ]);
    $router->put('subseccions/{subseccion}', [
        'as' => 'admin.analisis.subseccion.update',
        'uses' => 'SubseccionController@update',
        'middleware' => 'can:analisis.subseccions.edit'
    ]);
    $router->delete('subseccions/{subseccion}', [
        'as' => 'admin.analisis.subseccion.destroy',
        'uses' => 'SubseccionController@destroy',
        'middleware' => 'can:analisis.subseccions.destroy'
    ]);
    $router->get('subseccions/search_ajax', [
        'as' => 'admin.analisis.subseccion.search_ajax',
        'uses' => 'SubseccionController@search_ajax',
    ]);
    $router->get('subseccions/determinaciones', [
      'as' => 'admin.analisis.subseccion.determinaciones',
      'uses' => 'SubseccionController@determinacion',
    ]);
    $router->bind('determinacion', function ($id) {
        return app('Modules\Analisis\Repositories\DeterminacionRepository')->find($id);
    });
    $router->get('determinacions', [
        'as' => 'admin.analisis.determinacion.index',
        'uses' => 'DeterminacionController@index',
        'middleware' => 'can:analisis.determinacions.index'
    ]);
    $router->get('determinacions/index-ajax', [
        'as' => 'admin.analisis.determinacion.index_ajax',
        'uses' => 'DeterminacionController@index_ajax',
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
    $router->post('determinacions/ordenar', [
        'as' => 'admin.analisis.determinacion.ordenar',
        'uses' => 'DeterminacionController@ordenar',
        'middleware' => 'can:analisis.determinacions.ordenar'
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
// append
});
$router->group(['prefix' =>'/configuraciones'], function (Router $router) {
  $router->get('reset-cont', [
    'as' => 'admin.configuraciones.reset_cont',
    'uses' => 'AnalisisController@resetCont'
  ]);
});
