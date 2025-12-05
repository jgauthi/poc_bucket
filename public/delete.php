<?php
require_once __DIR__.'/init.inc.php';

// nom du bucket
$bucketName = 'mon-super-bucket-poc';

$file = $_GET['file'] ?? null;
if (!$file) {
    die("Aucun fichier spécifié.");
}

$bucket = init_bucket_client();
$object = $bucket->object($file);

// vérifier que l’objet existe
if (!$object->exists()) {
    die("Fichier introuvable.");
}

$object->delete();

// petite redirection propre
header("Location: index.php?deleted=" . urlencode($file));
exit;
