<?php

$container = new \Illuminate\Container\Container();

$container->singleton(\JWTPOC\Infrastructure\Services\Settings::class, function () {
    // @todo refactor to use a storage engine (file storage with path / database storage with credentials)
    $settingsPath = __DIR__ . '/../storage/persistence/settings.json';
    $fs = new Symfony\Component\Filesystem\Filesystem();
    $settings = new \JWTPOC\Infrastructure\Services\Settings($fs, $settingsPath);

    return $settings;
});

//$container->when(\JWTPOC\Application\Http\Kernel::class)
//    ->needs(\JWTPOC\Infrastructure\Services\Settings::class)
//    ->give(\JWTPOC\Infrastructure\Services\Settings::class);
