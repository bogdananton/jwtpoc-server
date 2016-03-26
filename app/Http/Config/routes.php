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
        'uses' => '\JWTPOC\Http\Controllers\IntrospectionController@get',
    ]);

    $router->get('clients', [
        'uses' => '\JWTPOC\Http\Controllers\ClientsController@getListing',
    ]);

    $router->get('settings', [
        'uses' => '\JWTPOC\Http\Controllers\SettingsController@getListing',
    ]);
});

