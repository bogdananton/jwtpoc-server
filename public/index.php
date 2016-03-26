<?php
date_default_timezone_set('Europe/Bucharest');

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \JWTPOC\Http\Kernel();
$app->run();

