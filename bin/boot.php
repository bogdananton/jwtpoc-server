<?php
// @todo use symfony console instead

require_once __DIR__ . '/../vendor/autoload.php';

$storagePath = __DIR__ . '/../storage/';
$keyPath = $storagePath . 'keys/mine/mine';
$settingsTemplateFile = $storagePath . 'settings-sample.json';
$settingsDestinationFile = $storagePath . 'settings.json';
$clientsDestinationFile = $storagePath . 'clients.json';

// set default keys
$rsa = new phpseclib\Crypt\RSA();
extract($rsa->createKey(512));

file_put_contents($keyPath . '.prv', $privatekey);
file_put_contents($keyPath . '.pub', $publickey);

// set settings
$contents = file_get_contents($settingsTemplateFile);
file_put_contents($settingsDestinationFile, $contents);

// set empty clients list
file_put_contents($clientsDestinationFile, json_encode([], JSON_PRETTY_PRINT));


echo PHP_EOL . 'Done.' . PHP_EOL . PHP_EOL;
