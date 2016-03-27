<?php

// @todo disable following statements and debug why the container doesn't share these contextual bindings.

$container = $this;

$container
    ->when(\JWTPOC\Resources\Settings\Persistence\Repository::class)
    ->needs(\JWTPOC\Contracts\Settings\Gateway::class)
    ->give(function () {
        $settingsPath = ROOT_PATH . 'storage/persistence/settings.json';

        $fs = new Symfony\Component\Filesystem\Filesystem();
        $factory = new \JWTPOC\Resources\Settings\Persistence\Factory();

        $gateway = new \JWTPOC\Resources\Settings\Persistence\Gateways\JSONFile($fs, $settingsPath, $factory);
        return $gateway;
    });

$container
    ->when(\JWTPOC\Resources\Settings\Persistence\Repository::class)
    ->needs(\JWTPOC\Contracts\Keys\Gateway::class)
    ->give(function () {
        $path = ROOT_PATH . 'storage/keys/';

        $fs = new Symfony\Component\Filesystem\Filesystem();
        $factory = new \JWTPOC\Resources\Keys\Persistence\Factory();

        $gateway = new \JWTPOC\Resources\Keys\Persistence\Gateway($fs, $path, $factory);
        return $gateway;
    });
