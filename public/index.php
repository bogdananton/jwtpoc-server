<?php
date_default_timezone_set('Europe/Bucharest');

define('ROOT_PATH', __DIR__ . '/../');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/dependencies.php';

/** @var \JWTPOC\Application\Http\Kernel $app */
$app = $container->build(\JWTPOC\Application\Http\Kernel::class);
$app->setInstance($container);
$app->run();

