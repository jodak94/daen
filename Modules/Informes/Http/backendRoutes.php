<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/informes'], function (Router $router) {
    $router->bind('informe', function ($id) {
        return app('Modules\Informes\Repositories\InformeRepository')->find($id);
    });
    $router->get('informes', [
        'as' => 'admin.informes.informe.index',
        'uses' => 'InformeController@index',
        'middleware' => 'can:informes.informes.index'
    ]);
    $router->get('get-per-year', [
        'as' => 'admin.informes.informe.perYearAjax',
        'uses' => 'InformeController@getPerYearAjax',
        'middleware' => 'can:informes.informes.index'
    ]);
    $router->get('get-per-day', [
        'as' => 'admin.informes.informe.perDayAjax',
        'uses' => 'InformeController@getPerDayAjax',
        'middleware' => 'can:informes.informes.index'
    ]);
    $router->get('informes/anual', [
        'as' => 'admin.informes.informe.exportAnual',
        'uses' => 'InformeController@exportAnual',
        'middleware' => 'can:informes.informes.index'
    ]);

    $router->get('reportes', [
        'as' => 'admin.informes.reporte.index',
        'uses' => 'ReporteController@index',
        'middleware' => 'can:informes.reportes.index'
    ]);
    $router->get('reportes/pacientes-fuera-de-rango', [
        'as' => 'admin.informes.reporte.pacientesFueraDeRango',
        'uses' => 'ReporteController@pacientesFueraDeRango',
        'middleware' => 'can:informes.reportes.index'
    ]);
    $router->get('reportes/pacientes-fuera-de-rango/pdf', [
        'as' => 'admin.informes.reporte.pacientesFueraDeRangoPdf',
        'uses' => 'ReporteController@pacientesFueraDeRangoPdf',
        'middleware' => 'can:informes.reportes.index'
    ]);
// append

});
