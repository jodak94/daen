<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/resultados', 'middleware' => ['api', 'cors']], function (Router $router) {
    $router->post('generate-pdf', [
        'uses' => 'ApiController@generatePdf',
    ]);
});
