<?php

$container = new \Illuminate\Container\Container();

$container
    ->when(\JWTPOC\Resources\Settings\Persistence\Repository::class)
    ->needs(\JWTPOC\Resources\Settings\Persistence\GatewayInterface::class)
    ->give(function () {
        $settingsPath = __DIR__ . '/../storage/persistence/settings.json';
        $fs = new Symfony\Component\Filesystem\Filesystem();
        $gateway = new \JWTPOC\Resources\Settings\Persistence\Gateways\JSONFile($fs, $settingsPath);
        return $gateway;
    });
