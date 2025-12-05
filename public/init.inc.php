<?php
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;

if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('You must install libraries with composer install');
}

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config.inc.php';

// Init class
function init_bucket_client(string $bucketName = BUCKET_NAME): Bucket
{
    if (!file_exists(__DIR__ . '/../credentials.json')) {
        die('Le fichier de credentials Google Cloud Storage est manquant. Veuillez le créer à la racine du projet avec le nom credentials.json');
    }

    $storage = new StorageClient([
        'keyFilePath' => __DIR__ . '/../credentials.json',
    ]);
    return $storage->bucket($bucketName);
}