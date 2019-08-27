<?php

return [
    'analisis.analises' => [
        'index' => 'analisis::analises.list resource',
        'create' => 'analisis::analises.create resource',
        'edit' => 'analisis::analises.edit resource',
        'destroy' => 'analisis::analises.destroy resource',
    ],
    'analisis.seccions' => [
        'index' => 'analisis::seccions.list resource',
        'create' => 'analisis::seccions.create resource',
        'edit' => 'analisis::seccions.edit resource',
        'destroy' => 'analisis::seccions.destroy resource',
        'ordenar' => 'analisis::seccions.ordenar resource',
        'configurar' => 'analisis::seccions.configurar resource'
    ],
    'analisis.subseccions' => [
        'index' => 'analisis::subseccions.list resource',
        'create' => 'analisis::subseccions.create resource',
        'edit' => 'analisis::subseccions.edit resource',
        'destroy' => 'analisis::subseccions.destroy resource',
        'ordenar' => 'analisis::seccions.ordenar resource'
    ],
    'analisis.determinacions' => [
        'index' => 'analisis::determinacions.list resource',
        'create' => 'analisis::determinacions.create resource',
        'edit' => 'analisis::determinacions.edit resource',
        'destroy' => 'analisis::determinacions.destroy resource',
        'ordenar' => 'analisis::determinacions.ordenar resource'
    ],
    'analisis.resultados' => [
        'index' => 'analisis::resultados.list resource',
        'create' => 'analisis::resultados.create resource',
        'edit' => 'analisis::resultados.edit resource',
        'destroy' => 'analisis::resultados.destroy resource',
    ],
// append





];
