<?php
date_default_timezone_set('Europe/Bucharest');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/dependencies.php';

$container->make(\JWTPOC\Application\Http\Kernel::class)->run();
