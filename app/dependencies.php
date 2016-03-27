<?php

$container = new \Illuminate\Container\Container();

$container
    ->when(\JWTPOC\Resources\Settings\Persistence\Repository::class)
    ->needs(\JWTPOC\Contracts\Settings\Gateway::class)
    ->give(function () {
        $settingsPath = __DIR__ . '/../storage/persistence/settings.json';

        $fs = new Symfony\Component\Filesystem\Filesystem();
        $factory = new \JWTPOC\Resources\Settings\Persistence\Factory();

        $gateway = new \JWTPOC\Resources\Settings\Persistence\Gateways\JSONFile($fs, $settingsPath, $factory);
        return $gateway;
    });

$container
    ->when(\JWTPOC\Resources\Settings\Persistence\Repository::class)
    ->needs(\JWTPOC\Contracts\Keys\Gateway::class)
    ->give(function () {
        $path = __DIR__ . '/../storage/keys/';

        $fs = new Symfony\Component\Filesystem\Filesystem();
        $factory = new \JWTPOC\Resources\Keys\Persistence\Factory();

        $gateway = new \JWTPOC\Resources\Keys\Persistence\Gateway($fs, $path, $factory);
        return $gateway;
    });
