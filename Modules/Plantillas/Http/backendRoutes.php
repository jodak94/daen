<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/plantillas'], function (Router $router) {
    $router->bind('plantilla', function ($id) {
        return app('Modules\Plantillas\Repositories\PlantillaRepository')->find($id);
    });
    $router->get('plantillas', [
        'as' => 'admin.plantillas.plantilla.index',
        'uses' => 'PlantillaController@index',
        'middleware' => 'can:plantillas.plantillas.index'
    ]);
    $router->get('plantillas/create', [
        'as' => 'admin.plantillas.plantilla.create',
        'uses' => 'PlantillaController@create',
        'middleware' => 'can:plantillas.plantillas.create'
    ]);
    $router->post('plantillas', [
        'as' => 'admin.plantillas.plantilla.store',
        'uses' => 'PlantillaController@store',
        'middleware' => 'can:plantillas.plantillas.create'
    ]);
    $router->get('plantillas/{plantilla}/edit', [
        'as' => 'admin.plantillas.plantilla.edit',
        'uses' => 'PlantillaController@edit',
        'middleware' => 'can:plantillas.plantillas.edit'
    ]);
    $router->put('plantillas/{plantilla}', [
        'as' => 'admin.plantillas.plantilla.update',
        'uses' => 'PlantillaController@update',
        'middleware' => 'can:plantillas.plantillas.edit'
    ]);
    $router->delete('plantillas/{plantilla}', [
        'as' => 'admin.plantillas.plantilla.destroy',
        'uses' => 'PlantillaController@destroy',
        'middleware' => 'can:plantillas.plantillas.destroy'
    ]);
    $router->bind('plantilladetalle', function ($id) {
        return app('Modules\Plantillas\Repositories\PlantillaDetalleRepository')->find($id);
    });
    $router->get('plantilladetalles', [
        'as' => 'admin.plantillas.plantilladetalle.index',
        'uses' => 'PlantillaDetalleController@index',
        'middleware' => 'can:plantillas.plantilladetalles.index'
    ]);
    $router->get('plantilladetalles/create', [
        'as' => 'admin.plantillas.plantilladetalle.create',
        'uses' => 'PlantillaDetalleController@create',
        'middleware' => 'can:plantillas.plantilladetalles.create'
    ]);
    $router->post('plantilladetalles', [
        'as' => 'admin.plantillas.plantilladetalle.store',
        'uses' => 'PlantillaDetalleController@store',
        'middleware' => 'can:plantillas.plantilladetalles.create'
    ]);
    $router->get('plantilladetalles/{plantilladetalle}/edit', [
        'as' => 'admin.plantillas.plantilladetalle.edit',
        'uses' => 'PlantillaDetalleController@edit',
        'middleware' => 'can:plantillas.plantilladetalles.edit'
    ]);
    $router->put('plantilladetalles/{plantilladetalle}', [
        'as' => 'admin.plantillas.plantilladetalle.update',
        'uses' => 'PlantillaDetalleController@update',
        'middleware' => 'can:plantillas.plantilladetalles.edit'
    ]);
    $router->delete('plantilladetalles/{plantilladetalle}', [
        'as' => 'admin.plantillas.plantilladetalle.destroy',
        'uses' => 'PlantillaDetalleController@destroy',
        'middleware' => 'can:plantillas.plantilladetalles.destroy'
    ]);
// append


});
