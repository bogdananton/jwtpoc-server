<?php
use \Illuminate\Http\Response;

/** @var \MultiRouting\Router $router */
$router = $this->router;

$router->get('test-url', function () {
    return new Response([
        'success' => true,
    ]);
});