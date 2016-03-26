<?php
// phpseclib/phpseclib is required to use this, so run composer update --dev

require_once __DIR__ . '/../vendor/autoload.php';

$rsa = new phpseclib\Crypt\RSA();
//$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
//$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
//define('CRYPT_RSA_EXPONENT', 65537);
//define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
extract($rsa->createKey(512));

$keyFilename = time() . '-' . uniqid();

file_put_contents($keyFilename . '.prv', $privatekey);
file_put_contents($keyFilename . '.pub', $publickey);

echo PHP_EOL . sprintfs('Pair %s generated.', $keyFilename) . PHP_EOL . PHP_EOL;