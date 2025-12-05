<?php
require_once __DIR__.'/init.inc.php';

$file = $_GET['file'] ?? null;

if (!$file) {
    die('Fichier manquant');
}

$bucket = init_bucket_client();
$object = $bucket->object($file);

if (!$object->exists()) {
    die('Fichier non trouvé');
}

$info = $object->info();
$contentType = $info['contentType'] ?? 'application/octet-stream';
$filename = basename($file);

header('Content-Type: ' . $contentType);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . $info['size']);

$stream = $object->downloadAsStream();
echo $stream->getContents();