<?php
// @todo use symfony console instead

require_once __DIR__ . '/../vendor/autoload.php';

// source
$persistencePath = __DIR__ . '/../res/persistence/';
$settingsTemplateFile = $persistencePath . 'settings-sample.json';

// destination
$storagePath = __DIR__ . '/../storage/';
$settingsDestinationFile = $storagePath . 'persistence/settings.json';
$clientsDestinationFile = $storagePath . 'persistence/clients.json';

$keyPath = $storagePath . 'keys/';
$publicKeyPath = 'mine/default.pub';
$privateKeyPath = 'mine/default.prv';

// set default keys
$rsa = new phpseclib\Crypt\RSA();
extract($rsa->createKey(512));

file_put_contents($keyPath . $publicKeyPath, $privatekey);
file_put_contents($keyPath . $privateKeyPath, $publickey);

// set settings
$contents = file_get_contents($settingsTemplateFile);

// optional
$settingsContent = json_decode($contents);
foreach ($settingsContent as $index => $item) {
    if ($item->name == 'private-key') {
        $settingsContent[$index]->value = $privateKeyPath;
    }

    if ($item->name == 'public-key') {
        $settingsContent[$index]->value = $publicKeyPath;
    }
}

file_put_contents($settingsDestinationFile, json_encode($settingsContent, JSON_PRETTY_PRINT));

// set empty clients list
file_put_contents($clientsDestinationFile, json_encode([], JSON_PRETTY_PRINT));


echo PHP_EOL . 'Done.' . PHP_EOL . PHP_EOL;
