<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/resultados'], function (Router $router) {
    $router->post('generate-pdf', [
        'uses' => 'ApiController@generatePdf',
    ]);
    $router->get('resultado', [
        'uses' => 'ApiController@getResultado',
    ]);
});
