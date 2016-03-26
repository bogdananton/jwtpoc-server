<?php
// @todo use symfony console instead
require_once __DIR__ . '/../vendor/autoload.php';

$rsa = new phpseclib\Crypt\RSA();
//$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
//$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
//define('CRYPT_RSA_EXPONENT', 65537);
//define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
extract($rsa->createKey(512));

$keyFilename = time() . '-' . uniqid();

file_put_contents($keyFilename . '.pub', $publickey);
file_put_contents($keyFilename . '.prv', $privatekey);

echo PHP_EOL . sprintf('Pair %s generated.', $keyFilename) . PHP_EOL . PHP_EOL;
