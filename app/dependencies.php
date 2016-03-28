<?php
$container = new \Illuminate\Container\Container();

/**
 * Settings
 */
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

/**
 * Clients
 */
$container
    ->when(\JWTPOC\Resources\Clients\Infrastructure\Repository::class)
    ->needs(\JWTPOC\Contracts\Clients\Gateway::class)
    ->give(function () {
            $settingsPath = ROOT_PATH . 'storage/persistence/clients.json';

            $fs = new Symfony\Component\Filesystem\Filesystem();
            $factory = new \JWTPOC\Resources\Clients\Persistence\Factory();

            $gateway = new \JWTPOC\Resources\Clients\Persistence\Gateways\JSONFile($fs, $settingsPath, $factory);
            return $gateway;
    });

$container
    ->when(\JWTPOC\Resources\Clients\Infrastructure\Repository::class)
    ->needs(\JWTPOC\Contracts\Keys\Gateway::class)
    ->give(function () {
            $path = ROOT_PATH . 'storage/keys/';

            $fs = new Symfony\Component\Filesystem\Filesystem();
            $factory = new \JWTPOC\Resources\Keys\Persistence\Factory();

            $gateway = new \JWTPOC\Resources\Keys\Persistence\Gateway($fs, $path, $factory);
            return $gateway;
    });

//$container
//    ->when(\JWTPOC\Application\Http\Controllers\SettingsController::class)
//    ->needs(\JWTPOC\Resources\Settings\Domain\Factory::class)
//    ->give(\JWTPOC\Resources\Settings\Domain\Factory::class);
