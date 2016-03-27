<?php
use \Illuminate\Http\Response;

/** @var \MultiRouting\Router $router */
$router = $this->router;

$router->get('test-url', function () {
    return new Response([
        'success' => true,
    ]);
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('', [
        'uses' => '\JWTPOC\Application\Http\Controllers\IntrospectionController@get',
    ]);

    $router->get('clients', [
        'uses' => '\JWTPOC\Application\Http\Controllers\ClientsController@getListing',
    ]);

    $router->resource('settings', '\JWTPOC\Application\Http\Controllers\SettingsController');

    $router->get('settings/{name}/{attr}', [
        'uses' => '\JWTPOC\Application\Http\Controllers\SettingsController@getItemAttribute',
    ]);
});

